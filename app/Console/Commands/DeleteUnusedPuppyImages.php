<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Puppy;

class DeleteUnusedPuppyImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-unused-puppy-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup uploaded images that are no longer referenced in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all files under storage/app/public/puppies
        // using the public disk returns paths relative to the disk root, e.g., "puppies/abc.jpg"
        $storedImages = Storage::disk('public')->files('puppies');

        // get image paths referenced in the database (adjust field name as needed)
        // Example DB values might be '/storage/puppies/abc.jpg' or full URLs
        $usedImages = Puppy::pluck('image_url')->map(function ($url) {
            // normalize to the same format as $storedImages (e.g. "puppies/abc.jpg")
            $path = Str::replaceFirst('/storage/', '', $url);
            $path = Str::replaceFirst('storage/', '', $path);
            // If the DB stores full URL, remove the domain/asset parts as needed:
            $path = preg_replace('#^https?://[^/]+/#', '', $path);
            return $path;
        })->filter()->unique()->values()->all();

        // compute unused images
        $unused = array_values(array_diff($storedImages, $usedImages));
        $total = count($unused);

        if ($total === 0) {
            $this->info('No unused images found.');
            return 0;
        }

        $this->info("Found {$total} unused image" . ($total > 1 ? 's' : '') . '.');

        // show first three as preview
        $preview = array_slice($unused, 0, 3);
        foreach ($preview as $file) {
            $this->line(" - {$file}");
        }

        if ($total > 3) {
            $this->line(' + ' . ($total - 3) . ' more');
        }

        if (! $this->confirm('Would you like to delete these unused images?', false)) {
            $this->info('Operation cancelled.');
            return 0;
        }

        foreach ($unused as $file) {
            if (Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
                $this->info("Deleted: {$file}");
            } else {
                $this->line("Not found (skipped): {$file}");
            }
        }

        $this->info('Unused images deleted successfully.');
        return 0;
    }
}

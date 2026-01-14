<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class OptimizeWebpImageAction
{
    /**
     * Create a new class instance.
     */
    public function handle(string|UploadedFile $input): array
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($input);
        if ($image->width() > 1000) {
            $image->scale(width: 1000);
        }
        $encoded = $image->toWebp(quality: 95)->toString();
        $fileName = Str::random() . '.webp';

        return [
            'fileName' => $fileName,
            'webpString' => $encoded,
        ];
    }
}

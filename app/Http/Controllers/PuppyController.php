<?php

namespace App\Http\Controllers;

use App\Http\Resources\PuppyResource;
use Illuminate\Http\Request;
use App\Models\Puppy;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Actions\OptimizeWebpImageAction;

class PuppyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        return Inertia::render('puppies/index', [
            'puppies' => PuppyResource::collection(
                //Puppy::all()->load(['user', 'likedBy']),
                Puppy::query()
                    ->when($search, function ($query, $search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('trait', 'like', "%{$search}%");
                    })
                    ->with(['user', 'likedBy'])
                    ->latest()
                    ->paginate(6)
                    ->withQueryString()
            ),
            'filters' => [
                'search' => $search
            ]
        ]);
    }

    public function like(Request $request, Puppy $puppy)
    {
        sleep(3); // Simulate processing delay
        $puppy->likedBy()->toggle($request->user()->id);
        return back();
    }

    public function store(Request $request)
    {
        sleep(3); // Simulate processing delay
        $request->validate([
            'name' => 'required|string|max:255',
            'trait' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $image_url = null;

        if ($request->hasFile('image')) {

            $optimized = (new OptimizeWebpImageAction())->handle($request->file('image'));

            $path = 'puppies/' . $optimized['fileName'];
            $stored = Storage::disk('public')->put($path, $optimized['webpString']);

            if (!$stored) {
                return back()->withErrors(['image' => 'Failed to upload image.']);
            }
            $image_url = Storage::url($path);
        }

        $request->user()->puppies()->create([
            'name' => $request->name,
            'trait' => $request->trait,
            'image_url' => $image_url,
        ]);

        return back()->with('success', 'Puppy created successfully!');
    }
}

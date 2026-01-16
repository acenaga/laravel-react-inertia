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
    //------------------------
    // show all puppies
    //------------------------
    public function index(Request $request)
    {

        $search = $request->search;
        $request->session()->flash('info', 'You have arrived at the puppy index page!');
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
            'likedPuppies' => $request->user()
                ? PuppyResource::collection($request->user()->likedPuppies)
                : [],
            'filters' => [
                'search' => $search
            ]
        ]);
    }
    //------------------------
    // like function
    //------------------------

    public function like(Request $request, Puppy $puppy)
    {
        sleep(3); // Simulate processing delay
        $puppy->likedBy()->toggle($request->user()->id);
        return back();
    }
    //------------------------
    // Store
    //------------------------

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

        return redirect()->route('home', ['page' => 1])->with('success', 'Puppy created successfully!');
    }

    //------------------------
    // Delete
    //------------------------
    public function destroy(Request $request, Puppy $puppy)
    {
        if ($request->user()->cannot('delete', $puppy)) {
            return back()
                ->withErrors(['error' => 'You are not authorized to delete this puppy.']);
        }
        sleep(3); // Simulate processing delay

        // Authorization check (assuming you have a policy set up)
        //$this->authorize('delete', $puppy);

        // Delete the image from storage if it exists
        if ($puppy->image_url) {
            $imagePath = str_replace('/storage/', '', $puppy->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        // Delete the puppy record
        $puppy->delete();

        return redirect()
            ->route('home', ['page' => 1])
            ->with('warning', 'Puppy deleted successfully!');
    }

    //------------------------
    // Update
    //------------------------
    public function update(Request $request, Puppy $puppy)
    {
        sleep(1); // Simulate processing delay
        if ($request->user()->cannot('update', $puppy)) {
            return back()
                ->withErrors(['error' => 'You are not authorized to update this puppy.']);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'trait' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {

            // Delete the old image from storage if it exists
            if ($puppy->image_url) {
                $oldImagePath = str_replace('/storage/', '', $puppy->image_url);
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $optimized = (new OptimizeWebpImageAction())->handle($request->file('image'));

            $path = 'puppies/' . $optimized['fileName'];
            $stored = Storage::disk('public')->put($path, $optimized['webpString']);

            if (!$stored) {
                return back()->withErrors(['image' => 'Failed to upload image.']);
            }
            $puppy->image_url = Storage::url($path);
        }
        $puppy->name = $request->name;
        $puppy->trait = $request->trait;
        $puppy->save();
        return back()
            ->with('success', 'Puppy updated successfully!');
    }
}

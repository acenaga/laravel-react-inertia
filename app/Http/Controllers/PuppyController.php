<?php

namespace App\Http\Controllers;

use App\Http\Resources\PuppyResource;
use Illuminate\Http\Request;
use App\Models\Puppy;
use Inertia\Inertia;

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
        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'trait' => 'required|string|max:255',
        ]);

        $puppy = new Puppy();
        $puppy->name = $request->name;
        $puppy->trait = $request->trait;
        $puppy->user_id = $request->user()->id;
        $puppy->save();

        return back();
    }
}

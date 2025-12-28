<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function store (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'instructions' => 'required|string',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'cost_range' => 'required|in:low,medium,high',
            'minutes_to_make' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'calories_per_serving' => 'required|integer|min:0',
            'is_private' => 'required|boolean',
            'is_vegan' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        Recipe::create([
            ...$validated,
            'user_id' => auth()->id(),
            'image_path' => $imagePath,
        
        ]);


        return redirect()->route('dashboard')->with('success', 'Recipe created successfully!');
    }
}

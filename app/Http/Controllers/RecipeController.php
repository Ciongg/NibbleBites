<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class RecipeController extends Controller
{

    public function topNibbled()
    {
        $recipes = Recipe::withCount('nibbledByUsers')
            ->where('is_private', false)
            ->orderByDesc('nibbled_by_users_count')
            ->take(10)
            ->get();

        return inertia('TopNibbled', [
            'recipes' => $recipes,
        ]);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('user');
        
        // Check if recipe is private
        if ($recipe->is_private) {
            // Only the owner can view private recipes
            if (!auth()->check() || auth()->id() !== $recipe->user_id) {
                return inertia('Error403', [
                    'message' => 'This recipe is private and you do not have permission to view it.'
                ])->toResponse(request())->setStatusCode(403);
            }
        }
        
        return inertia('ViewRecipe', [
            'recipe' => $recipe,
        ]);
    }

    public function edit(Recipe $recipe)
    {
        // Only the owner can edit their recipe
        if (auth()->id() !== $recipe->user_id) {
            return inertia('Error403', [
                'message' => 'You are not authorized to edit this recipe.'
            ])->toResponse(request())->setStatusCode(403);
        }

        return inertia('EditRecipe', [
            'recipe' => $recipe,
        ]);
    }

    public function toggle(Recipe $recipe){
        $user = auth()->user();
        $user->nibbledRecipes()->toggle($recipe->id);
        
        $isNibbled = $user->nibbledRecipes()->where('recipe_id', $recipe->id)->exists();
        $nibbledCount = $recipe->nibbledByUsers()->count();
        
        return back()->with('nibbleData', [
            'is_nibbled' => $isNibbled,
            'nibbled_count' => $nibbledCount,
        ]);
    }

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
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

    

        Recipe::create([
            ...$validated,
            'user_id' => auth()->id(),
            'image_path' => $imagePath,
        ]);


        return redirect()->route('dashboard')->with('success', 'Recipe created successfully!');
    }

    public function update(Request $request, Recipe $recipe){
        // Only the owner can update their recipe
        if (auth()->id() !== $recipe->user_id) {
            return inertia('Error403', [
                'message' => 'You are not authorized to update this recipe.'
            ])->toResponse(request())->setStatusCode(403);
        }
        
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
            'image' => 'nullable|image|max:2048',
            'image_path' => 'nullable|string',
        ]);

        if($request->hasFile('image')){
            if($recipe->image_path){
                Storage::disk('public')->delete($recipe->image_path);
            }

        
            $imagePath = $request->file('image')->store('recipes', 'public');
            

        }

        $recipe->update([
            ...$validated,
            'image_path' => $request->hasFile('image') ?  $imagePath : $validated['image_path']
        ]);

        return redirect()->route('edit-recipe', $recipe->id);

      
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        $recipes = Recipe::where('title', 'like', '%' . $query . '%')
            ->where('user_id', '!=', auth()->id())
            ->where('is_private', false)
            ->get();

        // Handle AJAX autocomplete requests
        if ($request->wantsJson() || $request->input('autocomplete')) {
            return response()->json([
                'recipes' => $recipes,
            ]);
        }

        // Handle full page requests (including refresh)
        return inertia('SearchResults', [
            'recipes' => $recipes,
            'query' => $query,
        ]);
    }
}

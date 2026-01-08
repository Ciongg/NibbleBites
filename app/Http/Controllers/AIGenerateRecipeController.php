<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Recipe;

class AIGenerateRecipeController extends Controller
{
    public function show () {
        return inertia('AIGenerateRecipe');
    }

    public function generateRecipe(Request $request) {
        $validated = $request->validate([
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|max:255',
        ]);

        $ingredientsList = implode(", ", $validated['ingredients']);

        Log::info('=== AI Recipe Generation Request ===');
        Log::info('Input Ingredients:', $validated['ingredients']);

        $prompt = "You are a recipe generator. Return ONLY Valid JSON using this schema:
        {
            \"title\": string,
            \"ingredients\": [\"ingredient name\"],
            \"instructions\": string,
            \"difficulty\": \"beginner\" | \"intermediate\" | \"advanced\",
            \"cost_range\": \"low\" | \"medium\" | \"high\",
            \"minutes_to_make\": integer,
            \"servings\": integer,
            \"calories_per_serving\": integer,
            \"is_vegan\": boolean
        }
        
        Generate a recipe using ONLY these ingredients: $ingredientsList
        
        IMPORTANT: For the instructions field, format each step on a new line using \\n (newline character). Each step should be numbered and separated by \\n\\n (double newline).
        Example format for instructions: \"1. First step here\\n\\n2. Second step here\\n\\n3. Third step here\"
        
        REMINDER: Return ONLY JSON. Do NOT include any other text or explanations.
        ";

        $apiKey = config('services.azure.api_key');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ])->timeout(30)->post('https://nibblebites-resource.services.ai.azure.com/models/chat/completions?api-version=2024-05-01-preview', [
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 2048,
                'temperature' => 0.8,
                'top_p' => 0.1,
                'presence_penalty' => 0,
                'frequency_penalty' => 0,
                'model' => 'DeepSeek-V3-0324'
            ]);

            $generatedRecipe = null;

            if ($response->successful() && isset($response['choices'][0]['message']['content'])) {
                $generatedText = $response['choices'][0]['message']['content'];

                Log::info('=== Azure AI Response ===');
                Log::info('Raw Response Text:', ['text' => $generatedText]);

                // Remove markdown code blocks if present
                $generatedText = preg_replace('/```json\s*|\s*```/', '', $generatedText);
                $generatedText = trim($generatedText);

                try {
                    $generatedRecipe = json_decode($generatedText, true, 512, JSON_THROW_ON_ERROR);
                    Log::info('Parsed Recipe:', $generatedRecipe);
                } catch (\JsonException $e) {
                    Log::error('JSON Parse Error:', ['error' => $e->getMessage(), 'text' => $generatedText]);
                    return back()->withErrors(['api_error' => 'Failed to parse generated recipe. Please try again.']);
                }
            } else {
                $errorDetails = $response->json() ?? 'No details available';
                Log::error('=== Azure AI Error ===');
                Log::error('Status Code:', ['status' => $response->status()]);
                Log::error('Error Details:', ['details' => $errorDetails]);
                return back()->withErrors(['api_error' => 'Failed to generate recipe. Please try again.']);
            }

            Log::info('=== Recipe Generation Complete ===');
            
            return inertia('AIGenerateRecipe', [
                'generatedRecipe' => $generatedRecipe,
                'ingredients' => $validated['ingredients'],
            ]);

        } catch (\Exception $e) {
            Log::error('Azure AI API call failed: ' . $e->getMessage());
            return back()->withErrors(['api_error' => 'An error occurred while generating the recipe.']);
        }
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
            'is_vegan' => 'required|boolean',
        ]);

        $recipe = Recipe::create([
            ...$validated,
            'user_id' => auth()->id(),
            'is_private' => false,
        ]);

        return redirect()->route('edit-recipe', $recipe->id);
    }
}



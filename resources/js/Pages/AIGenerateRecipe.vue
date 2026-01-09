<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Swal from 'sweetalert2';
import { ref, computed } from 'vue';
import trashIcon from '@/Assets/img/Trash.svg';
import redPlusIcon from '@/Assets/img/red-plus.svg';
defineOptions({
    layout: AuthLayout,
})

const props = defineProps({
    user: Object,
    generatedRecipe: Object,
    ingredients: Array,
});

const ingredients = ref(['']);
const showResult = ref(false);
const generatedRecipe = ref({
    title: '',
    difficulty: 'beginner',
    minutes_to_make: 0,
    calories_per_serving: 0,
    servings: 0,
    ingredients: [],
    instructions: ''
});

const addIngredient = () => {
    const lastIngredient = ingredients.value[ingredients.value.length - 1];
    if(lastIngredient !== ''){
        ingredients.value.push('');
    } else {
        Swal.fire({
            toast: true,
            position: 'bottom-right',
            title: 'Incomplete Ingredient',
            text: 'Please fill in the last ingredient before adding a new one.',
            icon: 'warning',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    }
}

const handleIngredientKeydown = (event, index) => {
    if(event.key === 'Enter') {
        event.preventDefault();
        addIngredient();
    }
}

const removeIngredient = (index) => {
    ingredients.value.splice(index, 1);
}


const resetPage = () => {
    showResult.value = false;
    ingredients.value = [''];
}

const badgeColor = (difficulty) => {
    const colors = {
        'beginner': '#90EE90',
        'intermediate': '#FFD700',
        'advanced': '#FF6B6B'
    };
    return colors[difficulty] || '#90EE90';
};



  const form = useForm({
        'title': '',
        'difficulty': 'beginner',
        'minutes_to_make': '',
        'calories_per_serving': '',
        'cost_range': 'low',
        'is_vegan': false,
        'servings': '',
        'ingredients': [],
        'instructions': '',
    });


    
const filledIngredients = computed(() =>
  ingredients.value.filter(ing => ing.trim() !== '')
);

const saveRecipe = () => {
    // Populate form with generated recipe data
    form.title = generatedRecipe.value.title;
    form.difficulty = generatedRecipe.value.difficulty;
    form.minutes_to_make = generatedRecipe.value.minutes_to_make;
    form.calories_per_serving = generatedRecipe.value.calories_per_serving;
    form.cost_range = generatedRecipe.value.cost_range;
    form.is_vegan = generatedRecipe.value.is_vegan;
    form.servings = generatedRecipe.value.servings;
    form.ingredients = generatedRecipe.value.ingredients;
    form.instructions = generatedRecipe.value.instructions;

    form.post('/ai-generate-recipe/save', {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                toast: true,
                position: 'bottom-right',
                title: 'Recipe Saved',
                text: 'The generated recipe has been saved to your recipes.',
                icon: 'success',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        },
        onError: (errors) => {
            console.error('Error saving recipe:', errors);
            Swal.fire({
                toast: true,
                position: 'bottom-right',
                title: 'Error Saving Recipe',
                text: Object.values(errors).join(' '),
                icon: 'error',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    });
};

const generateRecipe = () => {
    
    if(filledIngredients.value.length === 0) {
        Swal.fire({
            toast: true,
            position: 'bottom-right',
            title: 'No Ingredients',
            text: 'Please add at least one ingredient.',
            icon: 'warning',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
        return;
    }

    form.ingredients = filledIngredients.value;
    
    console.log('=== AI Recipe Generation Started ===');
    console.log('Input Ingredients:', filledIngredients.value);
    
    form.post('/ai-generate-recipe/generate', {
        preserveScroll: true,
        preserveUrl: true,
        onSuccess: (response) => {
            console.log('=== AI Recipe Generation Success ===');
            console.log('Generated Recipe:', props.generatedRecipe);
            
            if(props.generatedRecipe) {
                generatedRecipe.value = props.generatedRecipe;
                showResult.value = true;
            }
        },
        onError: (errors) => {
            console.error('=== AI Recipe Generation Error ===');
            console.error('Errors:', errors);
            
            Swal.fire({
                toast: true,
                position: 'bottom-right',
                title: 'Error Generating Recipe',
                text: 'Failed to generate recipe. Please try again.',
                icon: 'error',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    });
}


</script>

<template>
    <Head title="AI Generate Recipe" />
    <SideNavbar/>
    <div class="content-area">
        <!-- Input Section -->
        <div class="recipe-container" v-if="!showResult">
            <div class="input-section">
                <h1 class="page-title">Instant Recipe</h1>
                <p class="page-subtitle">Enter your available ingredients and let AI create a recipe for you!</p>

                <div class="ingredients-section">
                    <h3 class="section-title centered">Your Ingredients</h3>
                    <span class="red-underline"></span>
                    
                    <div class="ingredients-list">
                        <div class="ingredient-item" v-for="(ingredient, index) in ingredients" :key="index">
                            <input 
                                type="text" 
                                class="ingredient-input" 
                                placeholder="Ingredient..."
                                v-model="ingredients[index]"
                                @keydown="handleIngredientKeydown($event, index)"
                            />
                            <button v-if="ingredients.length > 1" class="remove-btn" @click="removeIngredient(index)">
                                <img :src="trashIcon" alt="Remove" class="trash-icon" />
                            </button>
                        </div>
                    </div>

                    <button class="add-ingredient-btn" @click="addIngredient">
                        <img :src="redPlusIcon" alt="" class="plus-icon" />
                        Add Ingredient
                    </button>
                </div>

                <button :disabled="form.processing" @click="generateRecipe" class="generate-btn">
                    <span v-if="!form.processing">
                        Generate Recipe with AI
                    </span>

                    <span v-else class="loading-content">
                        <span class="loader"></span>
                        Generating Recipe...
                    </span>
                </button>
            </div>
        </div>

        <!-- Result Section -->
        <div class="recipe-container result-container" v-else>
            <div class="result-header">
                <button @click="resetPage" class="back-btn">← Generate New Recipe</button>
                <h2 class="result-title">{{ generatedRecipe.title }}</h2>
                <div class="difficulty-badge-header">
                    <span class="badge" :style="{ backgroundColor: badgeColor(generatedRecipe.difficulty || 'beginner') }">
                        {{ generatedRecipe.difficulty ? generatedRecipe.difficulty.charAt(0).toUpperCase() + generatedRecipe.difficulty.slice(1) : 'Beginner' }}
                    </span>
                </div>
                <span class="header-divider"></span>
            </div>

            <div class="result-content">
                <div class="result-left">
                    <div class="recipe-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ generatedRecipe.minutes_to_make || 0 }}</span>
                            <span class="stat-label">Minute/s</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-value">{{ generatedRecipe.calories_per_serving || 0 }}</span>
                            <span class="stat-label">Kcal/Serving</span>
                        </div>
                    </div>

                    <div class="result-info-box">
                        <h3 class="section-title">Recipe Information</h3>
                        <div class="info-item">
                            <span class="info-label">Servings:</span>
                            <span class="info-value">{{ generatedRecipe.servings || 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Difficulty:</span>
                            <span class="info-value">{{ generatedRecipe.difficulty ? generatedRecipe.difficulty.charAt(0).toUpperCase() + generatedRecipe.difficulty.slice(1) : 'Beginner' }}</span>
                        </div>
                    </div>
                </div>

                <div class="result-right">
                    <div class="ingredients-result-section">
                        <h3 class="section-title centered">Ingredients</h3>
                        <span class="red-underline"></span>
                        <ul class="ingredients-result-list">
                            <li v-for="(ingredient, index) in generatedRecipe.ingredients" :key="index">
                                {{ ingredient }}
                            </li>
                        </ul>
                    </div>

                    <div class="instructions-result-section">
                        <h3 class="section-title centered">Instructions</h3>
                        <span class="red-underline"></span>
                        <p class="instructions-text">{{ generatedRecipe.instructions }}</p>
                    </div>

                    <div class="save-recipe-section">
                        <button @click="saveRecipe" class="save-recipe-btn">
                            Save This Recipe
                        </button>
                        <span class="save-recipe-hint">This will add it to 'your recipes'</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

    .loader {
    width: 24px;
    height: 24px;
    border: 5px solid #ff6565;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 

    .loading-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    
.content-area {
    margin-left: 250px;
    padding: 2rem;
}

.recipe-container {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

.input-section {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.page-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin: 0;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #666;
    text-align: center;
    margin: 0;
}

.ingredients-section {
    display: flex;
    flex-direction: column;
}

.section-title {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 1rem 0;
}

.section-title.centered {
    text-align: center;
    font-size: 1.25rem;
}

.red-underline {
    display: block;
    width: 100%;
    height: 3px;
    background-color: #ddd;
    margin-bottom: 1rem;
}

.ingredients-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.ingredient-item {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.ingredient-input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.ingredient-input:focus {
    border-color: #A03535;
}

.remove-btn {
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    transition: opacity 0.3s ease;
}

.remove-btn:hover {
    opacity: 0.7;
}

.trash-icon {
    width: 20px;
    height: 20px;
    filter: invert(32%) sepia(98%) saturate(1234%) hue-rotate(334deg) brightness(85%) contrast(95%);
}

.add-ingredient-btn {
    background-color: white;
    color: #A03535;
    border: none;
    padding: 0.75rem;
    border-radius: 4px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.add-ingredient-btn:hover {
    background-color: #A03535;
    color: white;
    box-shadow: 0 6px 12px rgba(160, 53, 53, 0.25);
}

.add-ingredient-btn .plus-icon {
    width: 18px;
    height: 18px;
    transition: filter 0.3s ease;
}

.add-ingredient-btn:hover .plus-icon {
    filter: brightness(0) invert(1);
}

.generate-btn {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
}

.generate-btn:hover {
    background-color: #8a2d2d;
    box-shadow: 0 6px 12px rgba(160, 53, 53, 0.3);
}

.generate-btn:disabled {
    cursor: not-allowed;
    opacity: 0.6; /* optional, dims button */
}


/* Result Section Styles */
.result-container {
    max-width: 1200px;
}

.result-header {
    margin-bottom: 2rem;
}

.back-btn {
    background: none;
    border: none;
    color: #A03535;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0.5rem 0;
    margin-bottom: 1rem;
    transition: opacity 0.3s ease;
}

.back-btn:hover {
    opacity: 0.7;
}

.result-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
    margin: 0 0 1rem 0;
}

.difficulty-badge-header {
    display: flex;
    justify-content: center;
}

.header-divider {
    display: block;
    width: 100%;
    height: 2px;
    background-color: #e0e0e0;
    margin-top: 1.5rem;
}

.result-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
}

.result-left {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.difficulty-badge {
    display: flex;
    justify-content: center;
}

.badge {
    background-color: #90EE90;
    color: #333;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.recipe-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 1rem;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
}

.stat-divider {
    width: 2px;
    height: 40px;
    background-color: #ddd;
}

.result-info-box {
    background-color: #f9f9f9;
    padding: 1.5rem;
    border-radius: 8px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #ddd;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #666;
}

.info-value {
    color: #333;
}

.result-right {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.ingredients-result-section,
.instructions-result-section {
    display: flex;
    flex-direction: column;
}

.ingredients-result-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ingredients-result-list li {
    padding: 0.75rem;
    border-bottom: 1px solid #f0f0f0;
    color: #333;
    position: relative;
    padding-left: 2rem;
    display: flex;
    align-items: center;
}

.ingredients-result-list li::before {
    content: "•";
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #A03535;
    font-weight: bold;
    font-size: 1.2rem;
}

.ingredients-result-list li:last-child {
    border-bottom: none;
}

.instructions-text {
    padding: 1rem;
    background-color: #f9f9f9;
    border-radius: 8px;
    line-height: 1.6;
    color: #333;
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.save-recipe-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.save-recipe-btn {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.save-recipe-btn:hover {
    background-color: #8a2d2d;
    box-shadow: 0 6px 12px rgba(160, 53, 53, 0.3);
}

.save-recipe-hint {
    font-size: 0.85rem;
    color: #999;
    text-align: center;
}
</style>

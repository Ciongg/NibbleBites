<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import DashboardNavbar from '@/Components/DashboardNavbar.vue';
import Swal from 'sweetalert2';
import { computed, ref } from 'vue';
import trashIcon from '@/Assets/img/Trash.svg';
import redPlusIcon from '@/Assets/img/red-plus.svg';

defineOptions({
    layout: AuthLayout,
})

defineProps({
    user: Object,
});

const imagePreview = ref(null);

const form = useForm({
    title: '',
    ingredients: [''],
    instructions: '',
    is_private: false,
    is_vegan: false,
    difficulty: 'beginner',
    cost_range: 'low',
    minutes_to_make: null,
    servings: null,
    calories_per_serving: null,
    image: null,
})

const badgeColor = computed(() => {
    const colors = {
        'beginner': '#90EE90',
        'intermediate': '#FFD700',
        'advanced': '#FF6B6B'
    };
    return colors[form.difficulty] || '#90EE90';
});

const handleImageUpload = ({target}) => {
   const file = target.files?.[0];
    if (!file) return;

    form.image = file;
    imagePreview.value = URL.createObjectURL(file);
};

const createRecipe = () => {
    form.post('/create-recipe', {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                toast: true,
                position: 'bottom-right',
                title: 'Recipe Created Successfully',
                icon: 'success',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
            imagePreview.value = null;
        },
        onError: (errors) => {
            Swal.fire({
                title: 'Error Creating Recipe',
                html: Object.values(errors).join('<br>'),
                icon: 'error',
                confirmButtonText: 'Close',
                timer: 10000,
                timerProgressBar: true,
            })
        }
    });
}


const addIngredient = () => {
    const lastIngredient = form.ingredients[form.ingredients.length - 1];
    if(lastIngredient !== ''){
        form.ingredients.push('');
    }else{
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

const removeIngredient = (index) => {
    form.ingredients.splice(index, 1);
}

const removeImage = () => {
    form.image = null;
    imagePreview.value = null;
}
</script>

<template>
    <Head title="Create Recipe" />
        <SideNavbar/>
            <DashboardNavbar />
            <div class="content-area">
                <div class="recipe-container">
                    <div class="left-section">
                        <label class="image-upload">
                            <input
                                type="file"
                                class="hidden"
                                accept="image/*"
                                @change="handleImageUpload"
                            />

                            <div class="image-placeholder" v-if="!imagePreview">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="camera-icon">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                                <p>Click to upload image</p>
                            </div>
                            <div class="image-preview" v-else>
                                <img :src="imagePreview" alt="Recipe preview" />
                                <button type="button" class="remove-image-btn" @click.prevent="removeImage">
                                    <img :src="trashIcon" alt="Remove" class="trash-icon" />
                                </button>
                            </div>
                        </label>

                        <div class="difficulty-badge">
                            <span class="badge" :style="{ backgroundColor: badgeColor }">{{ form.difficulty.charAt(0).toUpperCase() + form.difficulty.slice(1) }}</span>
                        </div>

                        <div class="recipe-stats">
                            <div class="stat-item">
                                <span class="stat-value">{{ form.minutes_to_make || '0' }}</span>
                                <span class="stat-label">Minute/s</span>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <span class="stat-value">{{ form.calories_per_serving || '0' }}</span>
                                <span class="stat-label">Kcal/Serving</span>
                            </div>
                        </div>

                        <div class="additional-info">
                            <h3 class="section-title">Additional Information</h3>
                            
                            <div class="form-group">
                                <label class="form-label">Difficulty</label>
                                <select v-model="form.difficulty" class="form-select">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>

        

                            <div class="form-group">
                                <label class="form-label">Cost Range</label>
                                <select v-model="form.cost_range" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Minutes to Make</label>
                                <input type="number" v-model="form.minutes_to_make" class="form-input" placeholder="35" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Servings</label>
                                <input type="number" v-model="form.servings" class="form-input" placeholder="4" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Calories per Serving</label>
                                <input type="number" v-model="form.calories_per_serving" class="form-input" placeholder="350" />
                            </div>

                                <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" v-model="form.is_private" />
                                    Private Only
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" v-model="form.is_vegan" />
                                    Is Vegan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="right-section">
                        <input 
                            type="text" 
                            class="recipe-title-input" 
                            placeholder="Enter Recipe Title Here..."
                            v-model="form.title"
                        />

                        <div class="ingredients-section">
                            <h3 class="section-title centered">Ingredients</h3>
                            <span class="red-underline"></span>
                            <div class="ingredients-list">
                                <div class="ingredient-item" v-for="(ingredient, index) in form.ingredients" :key="index">
                                    <input 
                                        type="text" 
                                        class="ingredient-input" 
                                        placeholder="Ingredient..."
                                        v-model="form.ingredients[index]"
                                    />
                                    <button v-if="form.ingredients.length > 1" class="remove-btn" @click="removeIngredient(index)">
                                        <img :src="trashIcon" alt="Remove" class="trash-icon" />
                                    </button>
                                </div>
                         
                            </div>
                            <button class="add-ingredient-btn" @click="addIngredient">
                                <img :src="redPlusIcon" alt="" class="plus-icon" />
                                Add Ingredient
                            </button>
                        </div>

                        <div class="instructions-section">
                            <h3 class="section-title centered">Instructions</h3>
                            <span class="red-underline"></span>
                            <textarea 
                                v-model="form.instructions"
                                class="instructions-textarea" 
                                placeholder="Enter cooking instructions here..."
                            ></textarea>
                        </div>

                        <button @click="createRecipe" class="save-btn">
                            Create Recipe
                        </button>
                    </div>
                </div>
            </div>
</template>

<style scoped>
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f5f5f5;
}

.main-content {
    flex: 1;
    margin-left: 250px;
}

.content-area {
    margin-top: 80px;
    margin-left: 250px;
    padding: 2rem;
}

.recipe-container {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.left-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.image-upload {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
}

.hidden {
    display: none;
}

.image-placeholder {
    width: 100%;
    height: 100%;
    background-color: #f0f0f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.image-placeholder:hover {
    background-color: #e0e0e0;
}

.camera-icon {
    width: 60px;
    height: 60px;
    color: #999;
    margin-bottom: 0.5rem;
}

.image-placeholder p {
    color: #999;
    font-size: 0.9rem;
}

.image-preview {
    width: 100%;
    height: 100%;
    position: relative;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-image-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background-color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.remove-image-btn:hover {
    transform: scale(1.15);
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
    transition: background-color 0.3s ease;
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

.additional-info {
    background-color: #f9f9f9;
    padding: 1.5rem;
    border-radius: 8px;
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

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    color: #333;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-select,
.form-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.form-select:focus,
.form-input:focus {
    border-color: #A03535;
}

.right-section {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.recipe-title-input {
    width: 100%;
    padding: 1rem;
    border: none;
    border-bottom: 2px solid #f0f0f0;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    outline: none;
    transition: border-color 0.3s ease;
}

.recipe-title-input:focus {
    border-bottom-color: #A03535;
}

.ingredients-section {
    display: flex;
    flex-direction: column;
}

.ingredients-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
    max-height: 300px;
    overflow-y: auto;
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

.instructions-section {
    display: flex;
    flex-direction: column;
}

.instructions-textarea {
    width: 100%;
    min-height: 200px;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: inherit;
    resize: vertical;
    outline: none;
    transition: border-color 0.3s ease;
}

.instructions-textarea:focus {
    border-color: #A03535;
}

.save-btn {
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

.save-btn:hover {
    background-color: #8a2d2d;
    box-shadow: 0 6px 12px rgba(160, 53, 53, 0.3);
}
</style>
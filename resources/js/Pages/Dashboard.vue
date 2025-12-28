<script setup>
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import DashboardNavbar from '@/Components/DashboardNavbar.vue';

defineOptions({
    layout: AuthLayout,
})

defineProps({
    user: Object,
    recipes: Array,
});
</script>

<template>
    <Head title="Dashboard" />
    
    <DashboardNavbar />
    
    <div class="dashboard-container">
        <h1>Your Recipes</h1>
        
        <div v-if="recipes && recipes.length > 0" class="recipes-grid">
            <div v-for="recipe in recipes" :key="recipe.id" class="recipe-card">
                <div class="recipe-image">
                    <img v-if="recipe.image_path" :src="`/storage/${recipe.image_path}`" :alt="recipe.title" />
                    <div v-else class="no-image">No Image</div>
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title">{{ recipe.title }}</h3>
                    <div class="recipe-meta">
                        <span class="meta-item">
                            <span class="meta-label">Difficulty:</span>
                            <span class="difficulty-badge" :class="recipe.difficulty">
                                {{ recipe.difficulty.charAt(0).toUpperCase() + recipe.difficulty.slice(1) }}
                            </span>
                        </span>
                        <span class="meta-item">{{ recipe.minutes_to_make }} min</span>
                        <span class="meta-item">{{ recipe.calories_per_serving }} kcal</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-else class="no-recipes">
            <p>You haven't created any recipes yet.</p>
            <p>Click "Create Recipe" to get started!</p>
        </div>
    </div>
</template>

<style scoped>
.dashboard-container {
    margin-top: 80px;
    margin-left: 250px;
    padding: 2rem;
}

h1 {
    color: #A03535;
    margin-bottom: 2rem;
    font-size: 2rem;
}

.recipes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.recipe-card {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.recipe-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.recipe-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.recipe-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background-color: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-weight: 600;
}

.recipe-content {
    padding: 1.5rem;
}

.recipe-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 1rem 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.recipe-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.meta-item {
    font-size: 0.9rem;
    color: #666;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-label {
    font-weight: 600;
}

.difficulty-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

.difficulty-badge.beginner {
    background-color: #90EE90;
    color: #333;
}

.difficulty-badge.intermediate {
    background-color: #FFD700;
    color: #333;
}

.difficulty-badge.advanced {
    background-color: #FF6B6B;
    color: white;
}

.no-recipes {
    text-align: center;
    padding: 4rem 2rem;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.no-recipes p {
    font-size: 1.1rem;
    color: #666;
    margin: 0.5rem 0;
}

.no-recipes p:first-child {
    font-weight: 600;
    color: #333;
}
</style>
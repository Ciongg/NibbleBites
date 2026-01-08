<script setup>
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { computed } from 'vue';

defineOptions({
    layout: AuthLayout,
})

const props = defineProps({
    user: Object,
    recipe: Object,
});

const badgeColor = computed(() => {
    const colors = {
        'beginner': '#90EE90',
        'intermediate': '#FFD700',
        'advanced': '#FF6B6B'
    };
    return colors[props.recipe.difficulty] || '#90EE90';
});

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <Head :title="recipe.title" />
    
    <div class="content-area">
        <button @click="goBack" class="back-btn">← Back</button>
        
        <div class="recipe-container">
            <div class="left-section">
                <div class="image-display">
                    <img v-if="recipe.image_path" :src="`/storage/${recipe.image_path}`" :alt="recipe.title" />
                    <div v-else class="no-image">No Image</div>
                </div>

                <div class="difficulty-badge">
                    <span class="badge" :style="{ backgroundColor: badgeColor }">
                        {{ recipe.difficulty.charAt(0).toUpperCase() + recipe.difficulty.slice(1) }}
                    </span>
                </div>

                <div class="recipe-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ recipe.minutes_to_make }}</span>
                        <span class="stat-label">Minute/s</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <span class="stat-value">{{ recipe.calories_per_serving }}</span>
                        <span class="stat-label">Kcal/Serving</span>
                    </div>
                </div>

                <div class="additional-info">
                    <h3 class="section-title">Recipe Information</h3>
                    
                    <div class="info-item">
                        <span class="info-label">Difficulty:</span>
                        <span class="info-value">{{ recipe.difficulty.charAt(0).toUpperCase() + recipe.difficulty.slice(1) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Cost Range:</span>
                        <span class="info-value">{{ recipe.cost_range.charAt(0).toUpperCase() + recipe.cost_range.slice(1) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Minutes to Make:</span>
                        <span class="info-value">{{ recipe.minutes_to_make }} minutes</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Servings:</span>
                        <span class="info-value">{{ recipe.servings }} servings</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Calories per Serving:</span>
                        <span class="info-value">{{ recipe.calories_per_serving }} kcal</span>
                    </div>

                    <div class="tags">
                        <span v-if="recipe.is_private" class="tag">Private</span>
                        <span v-if="recipe.is_vegan" class="tag vegan">Vegan</span>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <h1 class="recipe-title">{{ recipe.title }}</h1>

                <div class="ingredients-section">
                    <h3 class="section-title centered">Ingredients</h3>
                    <span class="red-underline"></span>
                    <ul class="ingredients-list">
                        <li v-for="(ingredient, index) in recipe.ingredients" :key="index" class="ingredient-item">
                            {{ ingredient }}
                        </li>
                    </ul>
                </div>

                <div class="instructions-section">
                    <h3 class="section-title centered">Instructions</h3>
                    <span class="red-underline"></span>
                    <div class="instructions-content">
                        {{ recipe.instructions }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.content-area {
    margin-left: 250px;
    padding: 2rem;
    position: relative;
}

.back-btn {
    position: absolute;
    top: 2rem;
    left: 2rem;
    background: none;
    border: none;
    color: #999;
    font-size: 0.9rem;
    cursor: pointer;
    transition: color 0.3s ease;
    padding: 0;
    margin-bottom: 1rem;
}

.back-btn:hover {
    color: #666;
}

.recipe-container {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 2.5rem;
}

.left-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.image-display {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
}

.image-display img {
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

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e0e0e0;
}

.info-item:last-of-type {
    border-bottom: none;
}

.info-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 600;
}

.info-value {
    font-size: 0.9rem;
    color: #333;
    font-weight: 500;
}

.tags {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.tag {
    background-color: #A03535;
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

.tag.vegan {
    background-color: #4CAF50;
}

.right-section {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.recipe-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    color: #333;
    margin: 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.red-underline {
    display: block;
    width: 100%;
    height: 3px;
    background-color: #ddd;
    margin-bottom: 1.5rem;
}

.ingredients-section {
    display: flex;
    flex-direction: column;
}

.ingredients-list {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 300px;
    overflow-y: auto;
}

.ingredient-item {
    padding: 0.75rem 1rem;
    margin-bottom: 0.5rem;
    background-color: #f9f9f9;
    border-radius: 4px;
    font-size: 0.95rem;
    color: #333;
    position: relative;
    padding-left: 2rem;
}

.ingredient-item::before {
    content: "•";
    position: absolute;
    left: 0.75rem;
    color: #A03535;
    font-weight: bold;
    font-size: 1.2rem;
}

.instructions-section {
    display: flex;
    flex-direction: column;
}

.instructions-content {
    background-color: #f9f9f9;
    padding: 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #333;
    line-height: 1.6;
    white-space: pre-wrap;
    max-height: 400px;
    overflow-y: auto;
}
</style>

<script setup>
import { router } from '@inertiajs/vue3';
import nibbledIcon from '@/Assets/img/Nibbled.svg';
import { computed, ref } from 'vue';
const props = defineProps({
    recipe: Object,
});


const isNibbled = ref(props.recipe.is_nibbled ?? false);
const nibbleCount = ref(props.recipe.nibbled_count ?? 0);

const displayIngredients = (ingredients) => {
    if (!ingredients || ingredients.length === 0) return [];
    const maxItems = 4;
    return ingredients.slice(0, maxItems);
};

const costSymbol = computed(() => {
    const costMap = {
        'low': '$',
        'medium': '$$',
        'high': '$$$'
    };
    return costMap[props.recipe.cost_range] || '$';
});

const viewRecipe = () => {

    if (props.recipe.is_owned) {
        router.get(route('edit-recipe', { recipe: props.recipe.id }));
    } else {
        router.get(route('view-recipe', { recipe: props.recipe.id }));
    }
};

const handleNibble = (event) => {
    event.preventDefault();
    event.stopPropagation();
    
    router.post(`/recipes/${props.recipe.id}/nibble`, {}, {
        preserveScroll: true,
        preserveState: false,
        onBefore: () => {
            isNibbled.value = !isNibbled.value;
            nibbleCount.value += isNibbled.value ? 1 : -1;
        }
    });
};
</script>

<template>
    <div class="recipe-card" @click="viewRecipe">
        <div class="recipe-left">
            <div class="recipe-image">
                <img v-if="recipe.image_path" :src="`/storage/${recipe.image_path}`" :alt="recipe.title" />
                <div v-else class="no-image">No Image</div>
                <div class="image-overlay"></div>
            </div>
            <div class="recipe-stats">
                <div class="stat-row">
                    <span class="stat-item">
                        <span class="stat-value">{{ recipe.minutes_to_make }}</span>
                        <span class="stat-label">Minutes</span>
                    </span>
                    <span class="stat-divider">|</span>
                    <span class="stat-item">
                        <span class="stat-value">{{ recipe.calories_per_serving }}</span>
                        <span class="stat-label">Kcal</span>
                    </span>
                </div>
                <div class="badge-container">
                    <span class="difficulty-badge" :class="recipe.difficulty">
                        {{ recipe.difficulty.charAt(0).toUpperCase() + recipe.difficulty.slice(1) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="recipe-right">
            <div class="recipe-content">
                <h3 class="recipe-title">{{ recipe.title }}</h3>
                <div class="title-divider"></div>
                <div class="recipe-ingredients">
                    <p v-for="(ingredient, index) in displayIngredients(recipe.ingredients)" :key="index" class="ingredient-item">
                        {{ ingredient }}
                    </p>
                    <p v-if="recipe.ingredients && recipe.ingredients.length > 4" class="ingredient-item">...</p>
                </div>
                
                <button class="view-recipe-btn">View Recipe</button>
                
                <div class="recipe-footer">
                    <div class="footer-item">
                        <div class="footer-content">
                            <span class="cost-symbol">{{ costSymbol }}</span>
                            <span>{{recipe.cost_range}} cost</span>
                        </div>
                        <span class="footer-underline"></span>
                    </div>
                    <button class="footer-item nibble-btn"  @click.stop="handleNibble">
                        <div class="footer-content">
                            <img :src="nibbledIcon" alt="Nibble" class="nibble-icon" />
                            <span>{{nibbleCount}} nibbles</span>
                        </div>
                        <span class="footer-underline"></span>
                    </button>
                    <div class="footer-item">
                        <div class="footer-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <span>{{ recipe.views_count ?? 0 }}k views</span>
                        </div>
                        <span class="footer-underline"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.recipe-card {
    display: flex;
    background-color: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    height: 380px;
}

.recipe-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.recipe-left {
    width: 364px;
    position: relative;
    flex-shrink: 0;
}

.recipe-image {
    width: 100%;
    height: 100%;
    position: relative;
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

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(255, 255, 255, 0.1) 100%);
}

.recipe-stats {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    z-index: 1;
}

.stat-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    font-weight: 500;
    margin-top: 0.25rem;
    opacity: 0.9;
}

.stat-divider {
    color: #999;
    font-size: 1.2rem;
}

.badge-container {
    display: flex;
    justify-content: center;
}

.difficulty-badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
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

.recipe-right {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.recipe-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.recipe-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 0.75rem 0;
    text-align: center;
}

.title-divider {
    width: 100%;
    height: 1px;
    background-color: #ddd;
    margin-bottom: 1rem;
}

.recipe-ingredients {
    margin: 0 0 1.5rem 0;
    height: 160px;
    overflow: hidden;
}

.ingredient-item {
    font-size: 1rem;
    color: #666;
    margin: 0.5rem 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.view-recipe-btn {
    background-color: transparent;
    color: #A03535;
    border: 2px solid #A03535;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.view-recipe-btn:hover {
    background-color: #A03535;
    color: white;
}

.recipe-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.nibble-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.nibble-btn:hover {
    transform: scale(1.1);
}

.nibble-btn.nibbled .nibble-icon {
    filter: brightness(0) saturate(100%) invert(20%) sepia(95%) saturate(1500%) hue-rotate(345deg) brightness(90%) contrast(95%);
}

.nibble-btn:active {
    transform: scale(0.95);
}

.footer-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.15rem;
    color: #666;
    font-weight: 500;
}

.footer-content svg {
    color: #A03535;
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

.nibble-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    transition: filter 0.2s ease;
}

.cost-symbol {
    color: #A03535;
    font-weight: bold;
    font-size: 1.2rem;
}

.footer-underline {
    width: 100%;
    height: 0.5px;
    background-color: #A03535;
    margin-top: 0.25rem;
}
</style>

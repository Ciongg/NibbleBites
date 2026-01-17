<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import RecipeCard from '@/Components/RecipeCard.vue';
import { computed } from 'vue';

defineOptions({
    layout: AuthLayout,
})

defineProps({
    user: Object,
    recipes: Array,
});

const page = usePage();
const username = computed(() => page.props.auth?.user?.username || 'Guest');
</script>

<template>
    <Head title="Your Recipes" />
    
    <div class="dashboard-container">
        <div class="header-section">
            <h1>Nice to see you're back {{ username }}!</h1>
            <p class="subtitle">What will you cook today?</p>
        </div>
        
        <div v-if="recipes && recipes.length > 0" class="recipes-grid">
            <RecipeCard v-for="recipe in recipes" :key="recipe.id" :recipe="recipe" variant="grid" />
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

.header-section {
    margin-bottom: 2rem;
}

h1 {
    color: #333;
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
    font-weight: bold;
}

.subtitle {
    color: #999;
    font-size: 1.1rem;
    margin: 0;
}

.recipes-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
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

@media (max-width: 1400px) {
    .recipes-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        margin-top: 60px;
        margin-left: 0;
        padding: 1rem;
    }

    h1 {
        font-size: 1.5rem;
    }

    .subtitle {
        font-size: 1rem;
    }

    .recipes-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .dashboard-container {
        padding: 0.5rem;
    }

    h1 {
        font-size: 1.25rem;
    }

    .subtitle {
        font-size: 0.9rem;
    }
}
</style>

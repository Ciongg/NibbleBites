<script setup>
    import SideNavbar from '../Components/SideNavbar.vue';
    import DashboardNavbar from '../Components/DashboardNavbar.vue';
    import AuthLayout from '../Layouts/AuthLayout.vue';
    import RecipeCard from '../Components/RecipeCard.vue';
    import { Head } from '@inertiajs/vue3';

    defineOptions({
        layout: AuthLayout
    })

    defineProps({
        recipes: Array,
    });
</script>


<template>
    <Head title="Top Nibbled Recipes" />
    
    <DashboardNavbar/>

    <div class="dashboard-container">
        <div class="header-section">
            <h1>Top 10 Nibbled Recipes</h1>
            <p class="subtitle">Most popular recipes in our community</p>
        </div>

        <div v-if="recipes && recipes.length > 0" class="top-recipes-list">
            <div v-for="(recipe, index) in recipes.slice(0, 10)" :key="recipe.id" class="recipe-item">
                <div class="rank-indicator">
                    <span class="rank-text">#{{ index + 1 }}</span>
                </div>
                <div class="recipe-wrapper" :class="{ 'has-banner': index < 5 }">
                    <div v-if="index < 5" class="ranking-banner">
                        <span class="banner-text">TOP {{ index + 1 }}</span>
                    </div>
                    <RecipeCard :recipe="recipe" :showBackButton="index === 0" />
                </div>
            </div>
        </div>

        <div v-else class="no-recipes">
            <p>No top recipes available yet.</p>
            <p>Be the first to create a popular recipe!</p>
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

.top-recipes-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.recipe-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.rank-indicator {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #A03535 0%, #8B2E2E 100%);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(160, 53, 53, 0.3);
}

.rank-text {
    font-size: 1.2rem;
    font-weight: bold;
    color: white;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

.recipe-wrapper {
    flex: 1;
    position: relative;
}

.recipe-wrapper.has-banner {
    padding-top: 2rem;
}

.ranking-banner {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    padding: 0.5rem 1rem;
    border-radius: 8px 8px 0 0;
    text-align: center;
    font-weight: bold;
    font-size: 0.9rem;
    color: white;
    z-index: 5;
    box-shadow: 0 2px 8px rgba(160, 53, 53, 0.3);
    background: linear-gradient(135deg, #A03535 0%, #8B2E2E 100%);
}

.banner-text {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    letter-spacing: 1px;
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
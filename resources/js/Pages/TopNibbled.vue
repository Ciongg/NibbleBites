<script setup>
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
    
    <div class="dashboard-container">
        <div class="header-section">
            <h1>Top Nibbled Recipes</h1>
            <p class="subtitle">Most popular recipes in our community</p>
        </div>

        <div v-if="recipes && recipes.length > 0">
            <!-- Top 3 Featured Section -->
            <div class="top-three-section">
                <div class="top-three-grid">
                    <div v-for="(recipe, index) in recipes.slice(0, 3)" :key="recipe.id" class="featured-card">
                        <div class="rank-badge top-rank">
                            <span class="rank-text">#{{ index + 1 }}</span>
                        </div>
                        <RecipeCard :recipe="recipe" variant="grid" />
                    </div>
                </div>
            </div>

            <!-- Rest of Recipes (4-10) -->
            <div v-if="recipes.length > 3" class="rest-section">
                <div class="recipes-grid">
                    <div v-for="(recipe, index) in recipes.slice(3, 10)" :key="recipe.id" class="recipe-item">
                        <div class="rank-badge">
                            <span class="rank-text">#{{ index + 4 }}</span>
                        </div>
                        <RecipeCard :recipe="recipe" variant="grid" />
                    </div>
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

/* Top 3 Featured Section */
.top-three-section {
    background-color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 3rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.top-three-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.featured-card {
    position: relative;
}

.rank-badge.top-rank {
    position: absolute;
    top: -1rem;
    left: 50%;
    transform: translateX(-50%);
}

/* Rest of Recipes Section */
.rest-section {
    margin-top: 3rem;
}

.recipes-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.recipe-item {
    position: relative;
}

.rank-badge {
    z-index: 10;
    background: linear-gradient(135deg, #A03535 0%, #8B2E2E 100%);
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(160, 53, 53, 0.3);
}

.recipe-item .rank-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
}

.rank-text {
    font-size: 1rem;
    font-weight: bold;
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
    .top-three-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .recipes-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1024px) {
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

    .top-three-section {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .top-three-grid,
    .recipes-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .rank-badge.top-rank {
        top: -0.75rem;
    }

    .rank-text {
        font-size: 0.9rem;
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

    .top-three-section {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .top-three-grid,
    .recipes-grid {
        gap: 1.5rem;
    }

    .rank-badge.top-rank {
        padding: 0.3rem 0.6rem;
    }

    .rank-text {
        font-size: 0.85rem;
    }
}
</style>
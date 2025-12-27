<script setup>
import { Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue'
import homepageImg from '@/assets/img/Homepage.webp'
import dashboardPreviewImg from '@/assets/img/DashboardPreview.png'
import recipeIcon from '@/Assets/img/Recipe.svg'


defineOptions({
    layout: GuestLayout,
})

</script>

<template>
    <div class="homepage">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-image">
                <img :src="homepageImg" alt="Cooking" />
                <div class="image-overlay"></div>
                <div class="hero-overlay">
                    <img :src="recipeIcon" alt="Recipe" class="recipe-icon" />
                    <h2 class="hero-number">2300+</h2>
                    <p class="hero-text">Recipes Created</p>
                </div>
            </div>

            <div class="hero-content">
                <div class="info-card">
                    <h2 class="info-title">Your personal recipe notes, made simple.</h2>
                    <p class="info-description">
                        NibbleNotes is a recipe note-taking app built for home cooks, food 
                        lovers, and busy people who want their recipes organized in one 
                        place. Save your favorite dishes with all the details that matter 
                        calories, cooking time, difficulty, and your own personal notes.
                    </p>
                </div>

                <div class="info-card centered">
                    <p class="tagline">Cook, Share, Remember</p>
                    <Link href="/login" class="cta-button">Start Cooking</Link>
                    <h3 class="motto">Everything Better</h3>
                </div>
            </div>
        </section>

        <!-- Discover Section -->
        <section class="discover-section">
            <div class="discover-text">
                <h2 class="discover-title">Discover & Get Inspired</h2>
                <p class="discover-description">
                    Explore other users' profiles and view their shared recipes. 
                    See how others cook, learn new ideas, and get inspired by different 
                    styles from quick meals to advanced dishes.
                </p>
            </div>
                
            <div class="preview-image">
                <img :src="dashboardPreviewImg" alt="Dashboard Preview" />
            </div>
        </section>
    </div>
</template>

<style scoped>
.homepage {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 2rem 2rem;
}

/* Hero Section */
.hero-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 4rem;
}

.hero-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    height: 600px;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.hero-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 2;
}

.recipe-icon {
    width: 180px !important;
    height: 180px !important;
    margin: 0 auto 1rem;
    filter: brightness(0) invert(1);
}

.hero-number {
    font-size: 6rem;
    font-weight: bold;
    margin: 0;
    line-height: 1;
}

.hero-number sup {
    font-size: 4rem;
    vertical-align: super;
}

.hero-text {
    font-size: 2rem;
    margin: 0;
    font-weight: 600;
}

.hero-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    height: 100%;
}

.info-card {
    background: white;
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    flex: 1;
    display: flex;
    flex-direction: column;
}

.info-card.centered {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
}

.info-title {
    color: #A03535;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 1.5rem 0;
}

.info-description {
    color: #333;
    line-height: 1.6;
    margin: 0;
    text-align: justify;
}

.tagline {
    color: #A03535;
    font-size: 1.25rem;
    font-style: italic;
    margin: 0;
}

.cta-button {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.cta-button:hover {
    background-color: #8a2d2d;
}

.motto {
    color: #333;
    font-size: 2rem;
    font-weight: bold;
    font-style: italic;
    margin: 0;
}

/* Discover Section */
.discover-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
    background: white;
    padding: 3rem;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.discover-text {
    /* No extra styling needed, inherits from container */
}

.discover-title {
    color: #A03535;
    font-size: 2.25rem;
    font-weight: bold;
    margin: 0 0 1.5rem 0;
}

.discover-subtitle {
    color: #A03535;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 1.5rem 0;
}

.discover-description {
    color: #333;
    line-height: 1.6;
    margin: 0;
    text-align: justify;
}

.preview-image {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.preview-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section,
    .discover-section {
        grid-template-columns: 1fr;
    }

    .hero-image {
        height: 400px;
    }

    .hero-number {
        font-size: 4rem;
    }

    .hero-text {
        font-size: 1.5rem;
    }
}
</style>
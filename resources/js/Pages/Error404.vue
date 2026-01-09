<script setup>
import { Head, router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import DashboardNavbar from '@/Components/DashboardNavbar.vue';

defineOptions({
    layout: AuthLayout,
})

defineProps({
    auth: Object,
});

const goBack = () => {
    router.get('/dashboard');
};
</script>

<template>
    <Head title="404 - Not Found" />
    
    <DashboardNavbar />
    
    <div class="error-container">
        <div class="error-content">
            <div class="error-code">404</div>
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-message">
                The page you're looking for doesn't exist or has been moved.
            </p>
            <button @click="goBack" class="back-button">
                Go to Dashboard
            </button>
        </div>
    </div>
</template>

<style scoped>
.error-container {
    margin-top: 80px;
    margin-left: 250px;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 80px - 4rem);
}

.error-content {
    text-align: center;
    max-width: 600px;
    padding: 3rem;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.error-code {
    font-size: 6rem;
    font-weight: bold;
    color: #A03535;
    margin-bottom: 1rem;
    line-height: 1;
}

.error-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 1rem 0;
}

.error-message {
    font-size: 1.1rem;
    color: #666;
    margin: 0 0 2rem 0;
    line-height: 1.6;
}

.back-button {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.back-button:hover {
    background-color: #8a2d2d;
    box-shadow: 0 4px 8px rgba(160, 53, 53, 0.3);
}
</style>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import DashboardNavbar from '@/Components/DashboardNavbar.vue';

defineOptions({
    layout: AuthLayout,
})

defineProps({
    user: Object,
});
</script>

<template>
    <Head title="Dashboard" />
    
    <DashboardNavbar />
    
    <div class="dashboard-container">
        <h1>Welcome to your Dashboard</h1>
        <p>Hello, {{ user?.username }}!</p>
    </div>
</template>

<style scoped>
.dashboard-container {
    padding: 2rem;
    margin-top: 70px;
}

h1 {
    color: #A03535;
    margin-bottom: 1rem;
}
</style>
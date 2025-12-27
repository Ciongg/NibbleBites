<script setup>
    import TopNavbar from '@/Components/TopNavbar.vue';

</script>

<template>
    <div>
        <TopNavbar />
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.main-content {
    background-color: #F2EEEB;
    min-height: 100vh;
    padding: 0;
}
</style>
<script setup>
    import SideNavbar from '@/Components/SideNavbar.vue';

    defineProps({
      user: Object,
    });
</script>

<template>
    <div class="auth-layout">
        <SideNavbar :user="user" />
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.auth-layout {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    background-color: #F2EEEB;
    padding: 2rem;
}
</style>
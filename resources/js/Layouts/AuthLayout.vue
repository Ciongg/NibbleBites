<script setup>
    import SideNavbar from '@/Components/SideNavbar.vue';
    import { ref, watch, onUnmounted } from 'vue';
    import { router } from '@inertiajs/vue3';

    defineProps({
      user: Object,
    });

    const isSidebarOpen = ref(false);

    const toggleSidebar = () => {
        isSidebarOpen.value = !isSidebarOpen.value;
    };

    const closeSidebar = () => {
        isSidebarOpen.value = false;
    };

    // Lock/unlock body scroll when sidebar opens/closes
    watch(isSidebarOpen, (isOpen) => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    // Ensure scroll is restored on navigation
    router.on('start', () => {
        isSidebarOpen.value = false;
        document.body.style.overflow = '';
    });

    // Cleanup: ensure scroll is restored when component unmounts
    onUnmounted(() => {
        document.body.style.overflow = '';
    });
</script>

<template>
    <div class="auth-layout">
        <!-- Overlay for mobile -->
        <div 
            v-if="isSidebarOpen" 
            @click="closeSidebar" 
            class="sidebar-overlay"
        ></div>

        <SideNavbar :user="user" :is-open="isSidebarOpen" @close="toggleSidebar" />
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.auth-layout {
    display: flex;
    min-height: 100vh;
    position: relative;
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.main-content {
    flex: 1;
    background-color: #F2EEEB;
    padding: 2rem;
}

@media (max-width: 768px) {
    .sidebar-overlay {
        display: block;
    }

    .main-content {
        padding: 1rem;
    }
}
</style>
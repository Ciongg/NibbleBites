<script setup>
    import TopNavbar from '@/Components/TopNavbar.vue';
    import { ref, watch, onUnmounted } from 'vue';
    import { router } from '@inertiajs/vue3';

    const isMobileMenuOpen = ref(false);

    const toggleMobileMenu = () => {
        isMobileMenuOpen.value = !isMobileMenuOpen.value;
    };

    const closeMobileMenu = () => {
        isMobileMenuOpen.value = false;
    };

    // Lock/unlock body scroll when mobile menu opens/closes
    watch(isMobileMenuOpen, (isOpen) => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    // Ensure scroll is restored on navigation
    router.on('start', () => {
        isMobileMenuOpen.value = false;
        document.body.style.overflow = '';
    });

    // Cleanup: ensure scroll is restored when component unmounts
    onUnmounted(() => {
        document.body.style.overflow = '';
    });
</script>

<template>
    <div>
        <!-- Overlay for mobile menu -->
        <div 
            v-if="isMobileMenuOpen" 
            @click="closeMobileMenu" 
            class="menu-overlay"
        ></div>

        <TopNavbar :is-mobile-menu-open="isMobileMenuOpen" @toggle-menu="toggleMobileMenu" @close-menu="closeMobileMenu" />
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.menu-overlay {
    display: none;
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 99;
}

.main-content {
    background-color: #F2EEEB;
    min-height: 100vh;
    padding: 0;
}

@media (max-width: 768px) {
    .menu-overlay {
        display: block;
    }
}
</style>
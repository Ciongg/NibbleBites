<template>
  <nav class="top-navbar">
    <div class="navbar-content">
      <!-- Hamburger Menu Button -->
      <button 
        @click="$emit('toggle-menu')" 
        class="hamburger-button"
        aria-label="Toggle menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>

      <Link href="/" class="brand">
        <img :src="nibbledIcon" alt="NibbleNotes" class="brand-icon" />
        NibbleNotes
      </Link>
      
      <div class="nav-buttons" :class="{ 'mobile-menu-open': isMobileMenuOpen }">
        <Link href="/login" class="nav-btn" @click="$emit('close-menu')">
          <img :src="loginIcon" alt="" class="icon-small" />
          Login
        </Link>
        <Link href="/register" class="nav-btn" @click="$emit('close-menu')">
          <img :src="registerIcon" alt="" class="icon-small" />
          Register
        </Link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import nibbledIcon from '@/Assets/img/Nibbled.svg';
import loginIcon from '@/Assets/img/Login.svg';
import registerIcon from '@/Assets/img/Register.svg';

defineProps({
  isMobileMenuOpen: {
    type: Boolean,
    default: false
  }
});

defineEmits(['toggle-menu', 'close-menu']);
</script>

<style scoped>
.top-navbar {
  background-color: white;
  padding: 1rem 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  position: relative;
}

.navbar-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.brand {
  color: #A03535;
  font-size: 1.5rem;
  font-weight: bold;
  margin: 0;
  text-decoration: none;
  transition: opacity 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.brand-icon {
  width: 32px;
  height: 32px;
}

.brand:hover {
  opacity: 0.8;
}

.nav-buttons {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.home-btn {
  background-color: #A03535;
  color: white;
  border: none;
  padding: 0.5rem;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  text-decoration: none;
}

.home-btn:hover {
  background-color: #8a2d2d;
}

.home-btn svg {
  display: block;
}

.icon {
  width: 24px;
  height: 24px;
  filter: brightness(0) invert(1);
}

.nav-btn {
  background-color: #A03535;
  color: white;
  border: 2px solid #A03535;
  padding: 0.5rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
}

.nav-btn:hover {
  background-color: #8a2d2d;
  border-color: #8a2d2d;
}

.nav-btn svg {
  display: block;
}

.icon-small {
  width: 18px;
  height: 18px;
  filter: brightness(0) invert(1);
}

.hamburger-button {
  display: none;
  background-color: transparent;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.hamburger-button:hover {
  background-color: #f5f5f5;
}

.hamburger-button svg {
  width: 24px;
  height: 24px;
  color: #333;
  display: block;
}

@media (max-width: 768px) {
  .top-navbar {
    padding: 1rem;
  }

  .hamburger-button {
    display: block;
  }

  .brand {
    font-size: 1.25rem;
  }

  .brand-icon {
    width: 28px;
    height: 28px;
  }

  .nav-buttons {
    position: fixed;
    top: -100%;
    left: 0;
    right: 0;
    background-color: white;
    flex-direction: column;
    width: 100%;
    padding: 1.5rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: top 0.3s ease;
    z-index: 100;
  }

  .nav-buttons.mobile-menu-open {
    top: 60px;
  }

  .nav-btn {
    width: 100%;
    justify-content: center;
    padding: 0.75rem 1.5rem;
  }
}

@media (max-width: 480px) {
  .brand {
    font-size: 1.1rem;
  }

  .brand-icon {
    width: 24px;
    height: 24px;
  }
}
</style>

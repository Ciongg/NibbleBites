<template>
  <nav class="top-navbar">
    <div class="navbar-content">
      <Link href="/" class="brand">NibbleNotes</Link>
      
      <div class="nav-buttons">

        <Link href="/login" class="nav-btn">
          <img :src="loginIcon" alt="" class="icon-small" />
          Login
        </Link>
        <Link href="/register" class="nav-btn">
          <img :src="registerIcon" alt="" class="icon-small" />
          Register
        </Link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import homeIcon from '@/Assets/img/Home.svg';
import loginIcon from '@/Assets/img/Login.svg';
import registerIcon from '@/Assets/img/Register.svg';
</script>

<style scoped>
.top-navbar {
  background-color: white;
  padding: 1rem 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
</style>

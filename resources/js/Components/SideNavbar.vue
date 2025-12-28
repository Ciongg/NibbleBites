<template>
  <aside class="sidebar">
    <h2 class="sidebar-title">
      <img :src="nibbledIcon" alt="NibbleNotes" class="title-icon" />
      NibbleNotes
    </h2>
    
    <div class="user-profile">
      <div class="user-avatar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="user-icon">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      <div class="user-info">
        <p class="username">{{ user?.username }}</p>
        <p class="user-email">{{ user?.email }}</p>
      </div>
      <div class="recipe-badge">
        35 Recipes
      </div>
    </div>

    <nav class="sidebar-nav">
      <button class="sidebar-btn active" @click="goToDashboard">
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Dashboard
      </button>
      <button class="sidebar-btn">
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
        </svg>
        Your Recipes
      </button>
      <button class="sidebar-btn">
        <img :src="nibbledIcon" alt="" class="btn-icon" />
        Nibbled
      </button>
      <button class="sidebar-btn">
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        Profile
      </button>
    </nav>

    <button class="logout-btn" @click="Logout">
      <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
      </svg>
      Logout
    </button>
  </aside>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import nibbledIcon from '@/Assets/img/Nibbled.svg';

defineProps({
    user: Object,
});

const Logout = () => {
    router.post('/logout');
}

const goToDashboard = () => {
    router.get('/dashboard');
}

</script>

<style scoped>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  background-color: white;
  height: 100vh;
  padding: 2rem 1rem;
  box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.sidebar-title {
  color: #A03535;
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0 0 1.5rem 0;
  padding-bottom: 1rem;
  border-bottom: 2px solid #f0f0f0;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.title-icon {
  width: 28px;
  height: 28px;
}

.user-profile {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 2px solid #f0f0f0;
}

.user-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background-color: #A03535;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.user-icon {
  width: 50px;
  height: 50px;
  color: white;
}

.user-info {
  text-align: center;
  margin-bottom: 1rem;
}

.username {
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  margin: 0 0 0.25rem 0;
}

.user-email {
  font-size: 0.85rem;
  color: #999;
  margin: 0;
}

.recipe-badge {
  background-color: #A03535;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 50px;
  font-size: 0.9rem;
  font-weight: 600;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  flex-grow: 1;
}

.sidebar-btn {
  background-color: white;
  color: #333;
  border: none;
  padding: 0.75rem 1rem;
  text-align: left;
  cursor: pointer;
  font-size: 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.sidebar-btn.active {
  background-color: #A03535;
  color: white;
}

.btn-icon {
  width: 20px;
  height: 20px;
}

.sidebar-btn img.btn-icon {
  filter: none;
}

.sidebar-btn.active img.btn-icon {
  filter: brightness(0) invert(1);
}

.sidebar-btn:hover img.btn-icon {
  filter: brightness(0) invert(1);
}

.sidebar-btn:hover {
  background-color: #A03535;
  color: white;
}

.logout-btn {
  background-color: white;
  color: #333;
  border: 2px solid #e0e0e0;
  padding: 0.75rem 1rem;
  text-align: left;
  cursor: pointer;
  font-size: 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-top: auto;
}

.logout-btn:hover {
  background-color: #f8f9fa;
  border-color: #A03535;
  color: #A03535;
}
</style>

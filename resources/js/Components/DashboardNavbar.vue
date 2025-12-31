<template>
  <nav class="dashboard-navbar">
    <div class="search-container">
      <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
      </svg>
      <input 
        type="text" 
        class="search-input" 
        placeholder="Search recipes"
      />
    </div>

    <button @click="CreateRecipe" class="create-btn">
      <img :src="whitePlusIcon" alt="" class="plus-icon" />
      Create Recipe
    </button>
  </nav>
</template>

<script setup>

import { router } from '@inertiajs/vue3';
import whitePlusIcon from '@/Assets/img/white-plus.svg';

const CreateRecipe = () => {
  router.get('/create-recipe');
}

</script>

<style scoped>
.dashboard-navbar {
  position: fixed;
  top: 0;
  left: 250px;
  right: 0;
  height: 80px;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
  z-index: 100;
  box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);

}

.search-container {
  display: flex;
  align-items: center;
  background-color: #f5f5f5;
  border-radius: 25px;
  padding: 0.5rem 1.25rem;
  flex: 1;
  max-width: 500px;
  gap: 0.75rem;
}

.search-icon {
  width: 22px;
  height: 22px;
  color: #999;
  flex-shrink: 0;
}

.search-input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 1rem;
  color: #333;
  width: 100%;
}

.search-input::placeholder {
  color: #999;
}

.create-btn {
  background-color: #A03535;
  color: white;
  border: none;
  padding: 0.65rem 1.5rem;
  border-radius: 25px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: background-color 0.3s ease;
}

.create-btn:hover {
  background-color: #8a2d2d;
}

.plus-icon {
  width: 20px;
  height: 20px;
}
</style>

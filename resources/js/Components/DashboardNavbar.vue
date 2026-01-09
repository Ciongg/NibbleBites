<template>
  <nav class="dashboard-navbar">
    <div class="search-wrapper">
      <div class="search-container">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input 
          type="text" 
          class="search-input" 
          placeholder="search public recipes"
          v-model="searchQuery"
          @input="handleSearch"
          @focus="showDropdown = true"
          @blur="handleBlur"
          @keydown.enter="searchAll"
        />
      </div>

      <div v-if="showDropdown && searchResults.length > 0" class="search-dropdown">
        <div 
          v-for="recipe in searchResults.slice(0, 3)" 
          :key="recipe.id"
          class="search-result-item"
          @mousedown="goToRecipe(recipe.id)"
        >
          <div class="result-title">{{ recipe.title }}</div>
          <div class="result-meta">{{ recipe.difficulty }} • {{ recipe.minutes_to_make }} mins</div>
        </div>
        
        <button 
          v-if="searchResults.length > 3"
          class="see-all-btn"
          @mousedown="searchAll"
        >
          See all {{ searchResults.length }} results
        </button>
      </div>
    </div>

    <button @click="CreateRecipe" class="create-btn">
      <img :src="whitePlusIcon" alt="" class="plus-icon" />
      Create Recipe
    </button>
  </nav>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import whitePlusIcon from '@/Assets/img/white-plus.svg';

const searchQuery = ref('');
const searchResults = ref([]);
const showDropdown = ref(false);
let searchTimeout = null;

const CreateRecipe = () => {
  router.get('/create-recipe');
}

const handleSearch = () => {
  clearTimeout(searchTimeout);
  
  if (searchQuery.value.trim().length === 0) {
    searchResults.value = [];
    showDropdown.value = false;
    return;
  }

  searchTimeout = setTimeout(async () => {
    try {
      const response = await axios.get('/search', {
        params: { q: searchQuery.value },
      });
      
      searchResults.value = response.data.recipes || [];
      showDropdown.value = true;
    } catch (error) {
      console.error('Search error:', error);
      searchResults.value = [];
    }
  }, 300);
}

const handleBlur = () => {
  setTimeout(() => {
    showDropdown.value = false;
  }, 200);
}

const goToRecipe = (recipeId) => {
  router.get(`/recipes/${recipeId}`);
  showDropdown.value = false;
}

const searchAll = () => {
  if (searchQuery.value.trim().length > 0) {
    router.get('/search', { q: searchQuery.value });
    showDropdown.value = false;
  }
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

.search-wrapper {
  position: relative;
  flex: 1;
  max-width: 500px;
}

.search-container {
  display: flex;
  align-items: center;
  background-color: #f5f5f5;
  border-radius: 25px;
  padding: 0.5rem 1.25rem;
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

.search-dropdown {
  position: absolute;
  top: calc(100% + 0.5rem);
  left: 0;
  right: 0;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  overflow: hidden;
  z-index: 1000;
}

.search-result-item {
  padding: 0.75rem 1.25rem;
  cursor: pointer;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.2s ease;
}

.search-result-item:last-child {
  border-bottom: none;
}

.search-result-item:hover {
  background-color: #f9f9f9;
}

.result-title {
  font-weight: 600;
  color: #333;
  margin-bottom: 0.25rem;
}

.result-meta {
  font-size: 0.85rem;
  color: #999;
}

.see-all-btn {
  width: 100%;
  padding: 0.75rem 1.25rem;
  background-color: #A03535;
  color: white;
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.see-all-btn:hover {
  background-color: #8a2d2d;
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

<template>
  <div>
    <!-- Dashboard Navbar -->
    <nav class="dashboard-navbar">
      <!-- Hamburger Menu Button (Mobile Only) -->
      <button 
        @click="toggleMobileSidebar" 
        class="hamburger-button"
        aria-label="Toggle menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>

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
        <span class="create-text">Create Recipe</span>
      </button>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ 'sidebar-open': isOpen }">
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
          {{ recipeCount }} {{ recipeCount === 1 ? 'Recipe' : 'Recipes' }}
        </div>
      </div>

      <nav class="sidebar-nav">
        <button class="sidebar-btn" :class="{ active: isActive('dashboard') }" @click="goToDashboard">
          <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          Public Recipes
        </button>
        <button class="sidebar-btn" :class="{ active: isActive('your-recipes') }" @click="goToYourRecipes">
          <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
          </svg>
          Your Recipes
        </button>
        <button class="sidebar-btn" :class="{active: isActive('top-nibbled')}" @click="goToTopNibbed" >
          <img :src="nibbledIcon" alt="" class="btn-icon" />
          Top Nibbled
        </button>
        
        <button class="sidebar-btn" :class="{active: isActive('ai-generate-recipe')}" @click="goToAIGenerateRecipe" >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
          </svg>
          
          Generate Recipe
        </button>

        <button class="sidebar-btn" :class="{active: isActive('profile')}" @click="goToProfile" >
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
  </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import nibbledIcon from '@/Assets/img/Nibbled.svg';
import whitePlusIcon from '@/Assets/img/white-plus.svg';
import { computed, ref } from 'vue';
import axios from 'axios';

defineProps({
    isOpen: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close']);

const page = usePage();

const user = computed(() => page.props.auth?.user);
const recipeCount = computed(() => user.value?.recipes_count || 0);

// Search functionality
const searchQuery = ref('');
const searchResults = ref([]);
const showDropdown = ref(false);
let searchTimeout = null;

const isActive = (routeName) => {
    const currentRoute = page.url;
    if (routeName === 'dashboard') return currentRoute === '/dashboard';
    if (routeName === 'your-recipes') return currentRoute === '/recipes';
    if (routeName === 'profile') return currentRoute === '/profile';
    if (routeName === 'top-nibbled') return currentRoute === '/top-nibbled';
    if (routeName === 'ai-generate-recipe') return currentRoute === '/ai-generate-recipe';
    return false;
};

const CreateRecipe = () => {
  router.get('/create-recipe');
};

const handleSearch = () => {
  clearTimeout(searchTimeout);
  
  if (searchQuery.value.trim().length === 0) {
    searchResults.value = [];
    showDropdown.value = false;
    return;
  }

  searchTimeout = setTimeout(async () => {
    try {
      const response = await axios.get('/search/autocomplete', {
        params: { q: searchQuery.value },
      });
      
      searchResults.value = response.data.recipes || [];
      showDropdown.value = true;

    } catch (error) {
      console.error('Search error:', error);
      searchResults.value = [];
    }
  }, 300);
};

const handleBlur = () => {
  setTimeout(() => {
    showDropdown.value = false;
  }, 200);
};

const goToRecipe = (recipeId) => {
  router.get(`/recipes/${recipeId}`);
  showDropdown.value = false;
};

const searchAll = () => {
  if (searchQuery.value.trim().length > 0) {
    router.get('/search', { q: searchQuery.value });
    showDropdown.value = false;
  }
};

const Logout = () => {
    router.post('/logout');
};

const goToDashboard = () => {
    router.get('/dashboard');
};

const goToYourRecipes = () => {
    router.get('/recipes');
};

const goToProfile = () => {
    router.get('/profile');
};

const goToTopNibbed = () => {
    router.get('/top-nibbled');
};

const goToAIGenerateRecipe = () => {
    router.get('/ai-generate-recipe');
};

const toggleMobileSidebar = () => {
    emit('close'); // This will toggle the sidebar through the parent
};
</script>

<style scoped>
/* Dashboard Navbar Styles */
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
  gap: 1rem;
}

.hamburger-button {
  display: none;
  background-color: transparent;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 8px;
  transition: background-color 0.3s ease;
  flex-shrink: 0;
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

/* Sidebar Styles */
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

@media (max-width: 768px) {
  .dashboard-navbar {
    left: 0;
    padding: 0 0.75rem;
    height: 60px;
    gap: 0.5rem;
  }

  .hamburger-button {
    display: block;
    order: -1;
  }

  .search-wrapper {
    flex: 1;
    max-width: none;
  }

  .search-container {
    padding: 0.4rem 0.75rem;
  }

  .search-input {
    font-size: 0.9rem;
  }

  .create-btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    flex-shrink: 0;
  }

  .plus-icon {
    width: 16px;
    height: 16px;
  }

  .sidebar {
    left: -250px;
    transition: left 0.3s ease;
    z-index: 1000;
  }

  .sidebar.sidebar-open {
    left: 0;
  }
}

@media (max-width: 480px) {
  .dashboard-navbar {
    padding: 0 0.5rem;
  }

  .hamburger-button {
    padding: 0.25rem;
  }

  .hamburger-button svg {
    width: 20px;
    height: 20px;
  }

  .search-wrapper {
    max-width: 200px;
  }

  .search-container {
    padding: 0.35rem 0.6rem;
  }

  .search-input {
    font-size: 0.85rem;
  }

  .create-text {
    display: none;
  }

  .create-btn {
    padding: 0.5rem;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    justify-content: center;
  }

  .plus-icon {
    width: 18px;
    height: 18px;
  }
}
</style>

<script setup>
import { Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
defineOptions({
    layout: GuestLayout,
})

const form = useForm({
    login: '',
    password: ''
})

const handleLogin = () => {
    form.post('/login', {
        onSuccess: () => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                title: 'Login Successful',
                text: 'Welcome back to NibbleNotes!',
                icon: 'success',
                timer: 6000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        },
        onError: (errors) => {
            Swal.fire({
                title: 'Login Error',
                text: Object.values(errors).join(' '),
                icon: 'error',
                confirmButtonText: 'Close'
            })
        }
    })
} 
</script>

<template>
    <div class="auth-container">
        <Link href="/" class="back-home-btn">← Back to Home</Link>
        <div class="auth-card">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Login to your NibbleNotes account</p>
            
            <form @submit.prevent="handleLogin" class="auth-form">
                <div class="form-group">
                    <label for="login" class="form-label">Email or Username</label>
                    <input 
                        type="text" 
                        id="login" 
                        v-model="form.login"
                        class="form-input"
                        placeholder="Enter your email or username"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        v-model="form.password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    />
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>

            <p class="auth-link">
                Don't have an account? 
                <Link href="/register" class="link">Register here</Link>
            </p>
        </div>
    </div>
</template>

<style scoped>
.auth-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: calc(100vh - 80px);
    padding: 1rem 2rem;
    position: relative;
}

.back-home-btn {
    position: absolute;
    top: 1rem;
    left: 2rem;
    color: #999;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.back-home-btn:hover {
    color: #666;
}

.auth-card {
    background: white;
    padding: 2rem 2.5rem;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    margin-top: 1.5rem;
}

.auth-title {
    color: #A03535;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 0.5rem 0;
    text-align: center;
}

.auth-subtitle {
    color: #666;
    text-align: center;
    margin: 0 0 2rem 0;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    color: #333;
    font-weight: 600;
    font-size: 0.95rem;
}

.form-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #A03535;
}

.submit-btn {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 0.85rem;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 0.25rem;
}

.submit-btn:hover {
    background-color: #8a2d2d;
}

.auth-link {
    text-align: center;
    margin-top: 1.25rem;
    color: #666;
}

.link {
    color: #A03535;
    text-decoration: none;
    font-weight: 600;
}

.link:hover {
    text-decoration: underline;
}
</style>

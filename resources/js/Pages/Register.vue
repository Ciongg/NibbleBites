<script setup>
import { Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
defineOptions({
    layout: GuestLayout,
})


const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: ''
})



const register = () => {
    form.post('/register', {
        onSuccess: () => {
            Swal.fire({
                title: 'Registration Successful',
                text: 'Your account has been created successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        onError: (errors) => {
            Swal.fire({
                title: 'Registration Error',
                text: Object.values(errors).join(' '),
                icon: 'error',
                confirmButtonText: 'Close'
            })
        }
    });
}

</script>

<template>
    <div class="auth-container">
        <Link href="/" class="back-home-btn">← Back to Home</Link>
        <div class="auth-card">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join NibbleNotes today</p>
            
            <form @submit.prevent="register" class="auth-form">

                 <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="username" 
                        id="username" 
                        v-model="form.username"
                        class="form-input"
                        placeholder="Enter your username"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        v-model="form.email"
                        class="form-input"
                        placeholder="Enter your email"
                        required
                    />
                </div>

                <div class="form-row">
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

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            v-model="form.password_confirmation"
                            class="form-input"
                            placeholder="Confirm your password"
                            required
                        />
                    </div>
                </div>

                <button type="submit" class="submit-btn">Register</button>
            </form>

            <p class="auth-link">
                Already have an account? 
                <Link href="/login" class="link">Login here</Link>
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
    max-width: 600px;
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

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
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

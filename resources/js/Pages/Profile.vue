<script setup>
    import {usePage, useForm} from '@inertiajs/vue3';
    import AuthLayout from '../Layouts/AuthLayout.vue';
    import DashboardNavbar from '../Components/DashboardNavbar.vue';
    import SideNavbar from '../Components/SideNavbar.vue';
    import { ref } from 'vue';
    import Swal from 'sweetalert2';
  
    defineOptions({
        layout: AuthLayout,
    });

    const page = usePage();
    const user = page.props.auth.user;

    const form = useForm({
        username: user.username || '',
        email: user.email || '',
        phone_number: user.phone_number || '',
        location: user.location || '',
        bio: user.bio || '',
    })

    const saveChanges = () => {

        if(!form.isDirty){
                Swal.fire({
                    icon: 'info',
                    title: 'No Changes Detected',
                    text: 'You have not made any changes to your profile.',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
                return;
        }

        form.patch('/profile', {
            
            onSuccess: () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: 'Your profile has been updated successfully.',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            },
            onError: (errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: Object.values(errors).join(' '),
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            },
        })
    }



</script>

<template>
    <SideNavbar/>
    <DashboardNavbar/>
    <div class="content-area">
        <div class="profile-container">
            <h1 class="page-title">My Profile</h1>
            
            <div class="profile-form">
                <div class="form-row">
                    <div class="form-column">
                        <h3 class="section-title">Personal Information</h3>
                        <span class="red-underline"></span>
                        
                     
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input 
                                type="text" 
                                class="form-input" 
                                placeholder="Enter your username"
                                v-model="form.username"
                            />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                class="form-input" 
                                placeholder="Enter your email"
                                  v-model="form.email"
                            />
                        </div>
                    </div>

                    <div class="form-column">
                        <h3 class="section-title">Additional Details</h3>
                        <span class="red-underline"></span>
                        
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input 
                                type="tel" 
                                class="form-input" 
                                placeholder="Enter your phone number"
                                v-model="form.phone_number"
                            />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input 
                                type="text" 
                                class="form-input" 
                                placeholder="Enter your location"
                                 v-model="form.location"
                            />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Bio</label>
                            <textarea 
                                class="form-textarea" 
                                placeholder="Tell us about yourself..."
                                rows="3"
                                v-model="form.bio"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <button @click="saveChanges" class="save-btn">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.content-area {
    margin-left: 250px;
    margin-top: 80px;
    padding: 2rem;
    height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-container {
    background-color: white;
    border-radius: 12px;
    padding: 2rem;
    max-width: 1000px;
    width: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 1.75rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 1.5rem 0;
    text-align: center;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.form-column {
    display: flex;
    flex-direction: column;
}

.section-title {
    font-size: 1.1rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 0.25rem 0;
}

.red-underline {
    display: block;
    width: 100%;
    height: 3px;
    background-color: #ddd;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.4rem;
}

.form-input {
    width: 100%;
    padding: 0.65rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    border-color: #A03535;
}

.form-textarea {
    width: 100%;
    padding: 0.65rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95rem;
    font-family: inherit;
    resize: vertical;
    outline: none;
    transition: border-color 0.3s ease;
}

.form-textarea:focus {
    border-color: #A03535;
}

.save-btn {
    background-color: #A03535;
    color: white;
    border: none;
    padding: 0.9rem 2rem;
    border-radius: 8px;
    font-size: 1.05rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.save-btn:hover {
    background-color: #8a2d2d;
    box-shadow: 0 6px 12px rgba(160, 53, 53, 0.3);
}
</style>
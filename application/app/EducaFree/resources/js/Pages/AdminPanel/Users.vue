<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import Table from "@/Components/AdminPanel/Table.vue";
    import { Head} from '@inertiajs/vue3';
    import  { ref } from 'vue'
    import { fetchUserData } from '@/Pages/AdminPanel/services/fetchUsersData.js';
    import Loading from '../../Components/Loading.vue';

    // Definicion de variables reactivas
    const users = ref([]);
    const searchTerm = ref('');
    let isLoading = ref(false);

    import { onMounted } from 'vue';
    // Cargar los usuarios al montar el componente
    onMounted(async () => {
    try {
        isLoading.value = true
        users.value = await fetchUserData();
        isLoading.value = false;
        
    } catch (error) {
        console.error('Error fetching user data:', error);
        isLoading.value = false;
    }
    });

    // Filtrar los reportes por busqueda (Nombre)
    async function filterUsers() {
    try {
        users.value = await fetchUserData(searchTerm.value);
    } catch (error) {
        console.error('Error filtering user data:', error);
    }
    }
</script>

<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">
        <div class="mb-5">
            <form class="max-w-md mx-auto" @submit.prevent="filterUsers">   
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" v-model="searchTerm" @input="filterUsers" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..." required />
                </div>
            </form>
        </div>
        <Table :Items="users" :Categorie="'users'" />
    </PanelLayout>

    <Loading :loading="isLoading"></Loading>
</template>
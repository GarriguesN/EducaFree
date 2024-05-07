<script setup>
import Navbar from '../Components/Header-nav-footer/Navbar.vue';
import Footer from '../Components/Header-nav-footer/Footer.vue';
import ToggleDark from  '../Components/ToggleDark.vue';
import { fetchRequestData } from '@/Pages/AdminPanel/services/fetchRequestsData';

// Definicion de props
defineProps({
    cmid: {
        type: Number,
        default: null
    }
})
const requests = ref({})
onMounted(async () => {
    try {
        requests.value = await fetchRequestData('', true);
    
    } catch (error) {
        console.error('Error fetching request data:', error);
    }
    });
</script>

<script>


// Importar y ejecutar la inicializacion de flowbite para algunos componentes
import { initFlowbite } from "flowbite";
import { onMounted, ref } from 'vue';
export default  {
    mounted() {
        initFlowbite();
    },
}

</script>

<template>
<main>
    <header>
        <Navbar :canLogin="$page.props.canLogin" :canRegister="$page.props.canRegister" :requests="requests" />
    </header>

    
    <article class="dark:bg-zinc-700 dark:text-white">
        
        <slot />
        
    </article>

    <footer v-if="cmid == null">
        <Footer />
    </footer>
</main>
<ToggleDark></ToggleDark>
</template>
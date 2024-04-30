<script setup>
import Navbar from '../Components/Header-nav-footer/Navbar.vue';
import Footer from '../Components/Header-nav-footer/Footer.vue';
import ToggleDark from  '../Components/ToggleDark.vue';

// Definicion de props
defineProps({
    cmid: {
        type: Number,
        default: null
    }
})
</script>

<script>
// Importar y ejecutar la inicializacion de flowbite para algunos componentes
import { initFlowbite } from "flowbite";
export default  {
    mounted() {
        initFlowbite();
    },
}
</script>

<template>
<main>

    <header>
        <Navbar :canLogin="$page.props.canLogin" :canRegister="$page.props.canRegister" />
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
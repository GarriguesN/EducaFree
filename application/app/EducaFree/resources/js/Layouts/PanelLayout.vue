<script setup>
import ArticleSide from '../Components/AdminPanel/Sidebar.vue';
import ToggleDark from  '../Components/ToggleDark.vue';
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
    <ArticleSide>
        <slot />

    </ArticleSide>
</main>
<ToggleDark :alwaysLight="true"></ToggleDark>
</template>
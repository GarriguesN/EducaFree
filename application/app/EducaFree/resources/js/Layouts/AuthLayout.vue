<script setup>
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

    <article>
        <div class="h-screen flex items-center justify-center dark:bg-zinc-700">
        <div class="h-2/5 w-screen bg-blue-600 flex items-center justify-center z-40 self-start shadow-xl"></div>
        <div class="hidden min-[950px]:block fixed z-50 top-20 left-0 w-full py-4">
            <p class="text-center text-white text-xl font-black">Learn free from anonymous people!</p>
        </div>
        <slot />
    </div>
    </article>

</main>
<ToggleDark></ToggleDark>
</template>
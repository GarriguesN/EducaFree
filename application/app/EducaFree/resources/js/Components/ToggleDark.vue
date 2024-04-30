<script setup>
    import { useDark, useToggle } from '@vueuse/core'

    const isDark = useDark()
    const toggleDark = useToggle(isDark)
</script>

<template>
    <button @click="toggleDark()" class="shadow-xl fixed bottom-16 left-0 right-0 z-[100] w-10 h-10 lg:w-16 lg:h-16 left-16 bg-gray-800 dark:bg-white rounded-full text-white dark:text-black font-semibold border">
        {{  isDark ? 'LHT' : 'DRK'}} 
    </button>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const showButton = ref(false);
const scrolling = ref(false)

const checkScroll = () => {
    const scrollPosition = window.scrollY;
    showButton.value = scrollPosition > 500;

    if(scrollPosition == 0) {
        scrolling.value = false
    }
}

onMounted(() => {
    window.addEventListener('scroll', checkScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkScroll);
});


const top = () => {
    scrolling.value = true
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>

<template>
    <button v-if="showButton" :class="scrolling ? 'disabled cursor-wait' : ''" class="shadow-xl fixed bottom-16 z-[100] flex justify-center items-center p-1 pr-2.5 right-16 bg-gray-800 hover:text-blue-400 dark:hover:text-blue-700 dark:bg-white rounded-full text-white dark:text-black font-semibold" @click="top()">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 11l-5-5-5 5M17 18l-5-5-5 5"/></svg>
        {{scrolling ? 'Scrolling...' : 'Scroll to top'}}
    </button>
</template>

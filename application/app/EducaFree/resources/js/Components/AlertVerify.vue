<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

    const props = defineProps({
        glowing: Boolean,
    })

    const page = usePage();
    const status = page.props;


    const clicked = ref(false);
    const error = ref(false)

    const submit = () => {
    // Send a POST request to the verification.send route
         router.post(route('verification.send'));

        clicked.value = true;

        if(page.props.flash.message){
            clicked.value = false;
            error.value = true;
            
            setTimeout(() => {
                error.value = false;
            }, 3000);
        }else{
            setTimeout(() => {
            clicked.value = false;
        }, 3000);
        }

        setTimeout(()=>{
            router.visit(window.location.href, {
            preserveScroll: true, // Preserve the scroll position after navigation
            preserveState: true, // Preserve the current state
        });
        }, 5000);
    };
</script>

<template>
    <div class="flex items-center justify-center p-2 text-sm text-blue-800 bg-blue-50/50 dark:bg-gray-800/50 dark:text-blue-400 text-center" :class="glowing ? 'bg-blue-700/90 text-white dark:bg-black/90 ease-in duration-300' : 'ease-in duration-300'" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div class="text-center">
            <span class="font-medium">Please verfiy your email!</span> Before you can access the full features of your account, please check your inbox for the verification email and follow the instructions to verify your email address. |
            <a @click="submit" class="hover:underline font-bold cursor-pointer"
             :class="[clicked ? 'text-green-600' : '',
                        error ? 'text-red-600' : ''
                    ]">
            Resend Verification Email </a>
            <span v-if="$page.props.flash.message" class="text-red-600">{{ $page.props.flash.message }}</span>
        </div>
    </div>
</template>
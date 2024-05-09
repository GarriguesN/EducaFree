<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import logo from '../../../../public/images/icon/logo.svg';

// Definicion de props
defineProps({
    status: String,
});

// Definicion del form
const form = useForm({
    email: '',
    password: '',
});

// Funcion para enviar el formulario de login
const submit = () => {
    // Transforma los datos del formulario antes de enviarlos
    form.transform(data => ({
        ...data, // Copia todos los campos existentes
        remember: form.remember ? 'on' : '',
    })).post(route('login'), { // Y los envia al servidor
        onFinish: () => form.reset('password'), // Al finalizar el envio, resetea el campo de password
    });
};


</script>

<template>
    <AuthLayout title="Login">
        <Head title="Log in" />


    <div class="border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[36rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white" :class="{ 'md:h-[36rem]': status }">
        <div class="flex items-center justify-center pt-1 pb-10">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500">EducaFree</span>
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
            {{ status }}
        </div>
        <form @submit.prevent="submit" class="h-full">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-center mt-10">
                <PrimaryButton class="ms-4 w-52 bg-blue-700 flex items-center justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>

            <div class="flex items-center justify-center mt-10">
                <p>Don't have an account? <a :href="route('register')" class="text-blue-600 dark:text-blue-500 dark:hover:text-blue-200 decoration underline hover:text-blue-800">Create one!</a></p>
            </div>
            <div class="flex items-center justify-center mt-10">
                <p><a :href="route('reset')" class="text-blue-600 decoration underline dark:text-blue-500 dark:hover:text-blue-200 hover:text-blue-800">Forgot your password?</a></p>
            </div>
        </form>
    </div>
    </AuthLayout>
    
</template>

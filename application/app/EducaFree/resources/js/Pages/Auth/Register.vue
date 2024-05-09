<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import logo from '../../../../public/images/icon/logo.svg';
import { fetchCheckEmailData } from './services/fetchCheckEmailData';
import { ref } from 'vue';

// Definicion del form
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const status = ref('');
// Funcion para enviar el formulario del register
const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'), // Resetea los valores de los inputs
    });
};

const handleSubmit = async (event) => {
    event.preventDefault();
    event.stopPropagation();

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Comprueba primero si es un email 'correcto'
    if (!emailPattern.test(form.email)) {
        status.value = 'Please enter a valid email address';
        form.reset('password', 'password_confirmation');
        setTimeout(() => {
            status.value = '';
        }, 3000);
        return;
    }

    if(await fetchCheckEmailData(form.email)){
        submit();
    }else{
        status.value = 'Email address not found. Please check your entry';
        form.reset('password', 'password_confirmation'),
        setTimeout(() => {
            status.value = ''
        }, 3000);
    }
}

</script>

<template>
    <AuthLayout title="Login">
    <Head title="Register" />
    <div class="border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[32rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white">
        <div class="flex items-center justify-center pt-1 pb-10">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500">EducaFree</span>
        </div>
        <div>
            <div class="flex items-center justify-center text-red-600">
                {{ status }}
            </div>
        </div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex gap-2 mt-5">
                <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            </div>
            
            <div @click="handleSubmit" class="flex items-center justify-center mt-10">
                <PrimaryButton class="ms-4 w-52 bg-blue-700 flex items-center justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
            <div class="flex items-center justify-center mt-4">
                <Link :href="route('login')" class="underline text-sm dark:text-gray-200 dark:hover:text-white text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Already registered?
                </Link>
            </div>
        </form>
    </div>
    </AuthLayout>
</template>

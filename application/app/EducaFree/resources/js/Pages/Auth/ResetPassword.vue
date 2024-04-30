<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
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
    password_confirmation: '',
    token: ''
});

// Funcion para enviar el formulario de login
const submit = () => {
    form.post(route('reset-password'), {
        onFinish: () => form.reset('password', 'password_confirmation'), // Resetea los valores de los inputs
    });
};

//Rellenar el form de email
form.email = usePage().props.email
form.token = usePage().props.token

</script>

<template>
    <AuthLayout title="Reset Password">
        <Head title="Reset Password" />


    <div class="border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[26rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white">
        <div class="flex items-center justify-center pt-1 pb-10">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500">EducaFree</span>
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
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
                    readonly
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex gap-2 mt-5">
                <div class="mt-4">
                <InputLabel for="password" value="New Password" />
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

            <div class="flex items-center justify-center mt-10">
                <PrimaryButton class="ms-4 w-52 bg-blue-700 flex items-center justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset password
                </PrimaryButton>
            </div>

        </form>
    </div>
    </AuthLayout>
    
</template>

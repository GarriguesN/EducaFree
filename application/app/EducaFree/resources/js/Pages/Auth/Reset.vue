<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import logo from '../../../../public/images/icon/logo.svg';

// Definicion de props
const props = defineProps({
    status: String,
});

// Definicion del form
const form = useForm({
    email: '',
});

// Funcion para enviar el formulario de login
const submit = () => {
    // Transforma los datos del formulario antes de enviarlos
    form.transform(data => ({
        ...data, // Copia todos los campos existentes
    })).post(route('sendEmail'), { // Y los envia al servidor
        onFinish: () => form.reset('email'), // Al finalizar el envio, resetea el campo de password
    });
};

</script>

<template>
    <AuthLayout title="Reset">
        <Head title="Reset Password" />

    <div class="border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[26rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white">
        <div class="flex items-center justify-center pt-1 pb-10">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500">EducaFree</span>
        </div>
        <div class="pb-5">
            <p>
                Forgot Your Password?
                Don't worry, it happens! Just enter your email address below and we'll send you instructions to reset your password.
            </p>
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-center" :class="{ 'text-green-600': status.type === 'Success', 'text-red-600': status.type === 'Error' }">
            {{ status.message }}
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

            <div class="flex items-center justify-center mt-10">
                <PrimaryButton class="ms-4 w-64 bg-blue-700 text-center flex items-center justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email password reset link
                </PrimaryButton>
            </div>

        </form>
    </div>
    </AuthLayout>
    
</template>

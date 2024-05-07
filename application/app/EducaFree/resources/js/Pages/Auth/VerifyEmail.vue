<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import logo from '../../../../public/images/icon/logo.svg';
const props = defineProps({
    status: String,
});
const form = useForm({});
const submit = () => {
    form.post(route('verification.send'));
};
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');

</script>
<template>
    <Head title="Email Verification" />
    <AuthLayout>
        <div class="border dark:border-gray-600 rounded p-10 shadow-lg m-5 md:h-[26rem] md:w-[30rem] absolute z-50 bg-white dark:bg-zinc-700 dark:text-white">
        <div class="flex items-center justify-center pt-1 pb-10">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-blue-700 text-2xl font-semibold whitespace-nowrap dark:text-blue-500">EducaFree</span>
        </div>
        <div class="pb-5">
            <p>
                Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-center" :class="{ 'text-green-600': status.type === 'Success', 'text-red-600': status.type === 'Error' }">
            {{ status.message }}
        </div>
        <form @submit.prevent="submit" class="h-full">
            <div class="flex items-center justify-center mt-10">
                <PrimaryButton class="ms-4 w-64 bg-blue-700 text-center flex items-center justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>
            </div>

        </form>
    </div>
    </AuthLayout>
</template>
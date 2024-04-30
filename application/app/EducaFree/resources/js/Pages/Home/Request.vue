<script setup>
    import Layout from "@/Layouts/Layout.vue";
    import {useForm} from '@inertiajs/vue3';
    import { Head, Link, router } from '@inertiajs/vue3';
    import FormRequest from "@/Components/Requests/Form.vue";

    // Definicion de form
    const form = useForm({
        title : '',
        description: '',
    })

</script>
<template>
    <Head title="Request"/>
    <Layout title="Request">
        <section class="bg-white h-72 flex justify-end content-center flex-col shadow-lg
                    dark:bg-zinc-700 dark:text-white
    ">
        <p class="text-center text-7xl font-[1000] mb-10">Requests</p>
    </section>
        <FormRequest :form="form" @submit="form.post(route('home.store'))" />
    </Layout>
</template>
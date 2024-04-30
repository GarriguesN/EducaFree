<script setup>
    import Layout from "@/Layouts/Layout.vue";
    import { Head, Link, router } from '@inertiajs/vue3';
    import About from '@/Components/Home/About.vue';

</script>
<template>
    <Head title="About Us"/>
    <Layout title="About Us">
        <About />
    </Layout>
</template>
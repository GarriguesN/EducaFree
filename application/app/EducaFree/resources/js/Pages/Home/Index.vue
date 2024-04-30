<script setup>
    import Layout from "@/Layouts/Layout.vue";
    import Home from "@/Components/Home/Home.vue"
    import { Head, Link, router } from '@inertiajs/vue3';

</script>
<template>
    <Head title="Home"/>
    <Layout title="Home">
        <Home/>
    </Layout>
</template>
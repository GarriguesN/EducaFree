<script setup>
    import Layout from "@/Layouts/Layout.vue";
    import Courses from "@/Components/Home/Courses.vue"
    import { Head } from '@inertiajs/vue3';

    // Definicion de props
    const props = defineProps({
    userId:{
        type: Number
    }
})

</script>
<template>
    <Head title="Home"/>
    <Layout title="Home">
        <Courses :userId="userId"/>
    </Layout>
</template>
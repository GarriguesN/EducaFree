<script setup>
    import Layout from "@/Layouts/Layout.vue";
    import Course from "@/Components/Courses/Course.vue"
    import { Head } from '@inertiajs/vue3';

    const currentPath = window.location.pathname;

    // Extraemos el número final de la URL actual para recoger el cmid del LSM (moodle)
    const cmid = currentPath.substring(currentPath.lastIndexOf('/') + 1);

</script>
<template>
    <Head title="Home"/>
    <Layout v-if="cmid == $page.props.course.id" title="Home" :cmid="null">
        <Course :course="$page.props.course" />
    </Layout>

    <Layout v-else title="Home" :cmid=cmid>
        <Course :course="$page.props.course" :cmid="cmid"/>
    </Layout>
</template>
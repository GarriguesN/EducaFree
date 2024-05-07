<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import Course from "@/Components/AdminPanel/CourseTab.vue"
    import { Head, Link, router } from '@inertiajs/vue3';

</script>
<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">
        <Course :course="$page.props.course" />
    </PanelLayout>
</template>
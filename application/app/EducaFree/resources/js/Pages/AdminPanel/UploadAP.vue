<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import Table from "@/Components/AdminPanel/Table.vue";
    import { Head, usePage} from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { fetchCourseData } from '@/Pages/AdminPanel/services/fetchCoursesData.js';
    import Loading from '../../Components/Loading.vue';
    import Upload from '@/Components/Home/Upload.vue';
    
    // Definicion de variables reactivas
    const page = usePage();
    let isLoading = ref(false);

</script>


<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">
        <Upload :adminpanel="true"></Upload>
    </PanelLayout>

    <Loading :loading="isLoading"></Loading>
</template>
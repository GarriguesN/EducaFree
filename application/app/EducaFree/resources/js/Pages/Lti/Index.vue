<script setup>
    import Courses from '../../Components/Home/Courses.vue';
    import Layout from '../../Layouts/Layout.vue';
    import { ref } from  'vue';

    // Definicion de props
    const props = defineProps({
        cmid: {
            type: Number,
            required: true
        },
        responseData: {
            type: Object,
            required: true
        },
        courses: {
            type: Object,
            required: true
        }
    })


</script>

<template>
    <Head title="Home"/>
        <Courses :cmid="cmid " :responseData="responseData" :coursesMoodle="courses"/>
</template>


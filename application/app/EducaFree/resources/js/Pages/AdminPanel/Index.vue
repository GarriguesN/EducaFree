<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import Table from "@/Components/AdminPanel/Table.vue"
    import { Head } from '@inertiajs/vue3';
    import UserCardInfo from "@/Components/AdminPanel/UserCardInfo.vue";
    import CourseCardInfo from "@/Components/AdminPanel/CourseCardInfo.vue";
    import RequestCardInfo from "@/Components/AdminPanel/RequestCardInfo.vue";
    import MostLikedCardInfo from "@/Components/AdminPanel/MostLikedCardInfo.vue";
    import CompletedCardInfo from "@/Components/AdminPanel/CompletedCardInfo.vue";
    import LitConsumerstCardInfo from "@/Components/AdminPanel/LitConsumerstCardInfo.vue";
    import { ref } from "vue";

    const rotate = ref(false);

    const rorateArrow = () => {
        rotate.value = !rotate.value;
    }
</script>
<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">

        <div id="accordion-open" data-accordion="open" class="mt-5 bg-slate-50 p-5 border-1 border-gray-300">
            <div id="accordion-open-body-1" class="block" aria-labelledby="accordion-open-heading-1">
                <div class="grid gap-5 pb-5 h-40" :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'grid-cols-2' : 'grid-cols-3'">
                    <!-- USUARIOS  -->
                    <div v-if="$page.props.user.roles.includes('admin')" class="flex justify-center items-center">
                        <UserCardInfo></UserCardInfo>
                    </div>
                    <!-- CURSOS -->
                    <div class="flex justify-center items-center">
                        <CourseCardInfo></CourseCardInfo>
                    </div>
                    <!-- REQUESTS / COMPLETED -->
                    <div class="flex justify-center items-center">
                        <RequestCardInfo></RequestCardInfo>
                    </div>
                </div>
            </div>
            <h2 id="accordion-open-heading-2">
                <button @click="rorateArrow" type="button" class="flex items-center justify-center w-full p-5 mt-5 font-medium bg-white text-gray-500 border border-gray-200 focus:ring-1 focus:ring-blue-700 hover:bg-gray-100 gap-3" data-accordion-target="#accordion-open-body-2" aria-expanded="false" aria-controls="accordion-open-body-2">
                <span class="flex items-center">
                    <svg class="w-5 h-5 me-2 shrink-0" :class="rotate ? ' rotate-180':'rotate-0'"xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    More Stats
                </span>
                </button>
            </h2>
            <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2">
                <div class="grid gap-5 pt-2 mt-3 mb-2" :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'grid-cols-1' : 'grid-cols-2'">
                    <div class="flex justify-center items-center col-span-2">
                        <MostLikedCardInfo></MostLikedCardInfo>
                    </div>
                    <div class="flex justify-center items-center">
                        <CompletedCardInfo></CompletedCardInfo>
                    </div>
                    <div v-if="$page.props.user.roles.includes('admin')"  class="flex justify-center items-center">
                        <LitConsumerstCardInfo></LitConsumerstCardInfo>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-10">
            <div v-if="$page.props.user.roles.includes('admin')" class="bg-slate-50 p-4 flex items-center flex-col">
                <div class="font-bold mb-3 flex">LAST USERS <a :href="route('dashboard.users')" class="hover:text-blue-600 ml-4 text-xs text-gray-400 flex items-center"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a></div>
                <Table :Items="$page.props.lastUsers" :Categorie="'lastUsers'" />
            </div> 
            <div :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'col-span-3' : 'col-span-2'" class="bg-slate-50 p-4 flex items-center flex-col col-span-2">
                <div class="font-bold mb-3 flex">LAST REQUESTS <a :href="route('dashboard.requests')" class="hover:text-blue-600 ml-4 text-xs text-gray-400 flex items-center"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a> </div>
                <Table :Items="$page.props.lastRequests" :Categorie="'lastRequests'" />
            </div>
        </div>
        <div class="grid grid-cols-3 gap-5 mt-10">
            <div  :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'col-span-3' : 'col-span-2'" class="bg-slate-50 p-4 flex items-center flex-col col-span-2">
                <div class="font-bold mb-3 flex">LAST PENDING COURSES <a :href="route('dashboard.pendingCourses')" class="hover:text-blue-600 ml-4 text-xs text-gray-400 flex items-center"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a></div>
                <Table :Items="$page.props.lastPending" :Categorie="'lastPending'" />
            </div> 
            <div v-if="$page.props.user.roles.includes('admin')" class="bg-slate-50 p-4 flex items-center flex-col">
                <div class="font-bold mb-3 flex">LAST REPORTS <a :href="route('dashboard.reports')" class="hover:text-blue-600 ml-4 text-xs text-gray-400 flex items-center"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a></div>
                <Table :Items="$page.props.lastReports" :Categorie="'lastReports'" />
            </div>
        </div>
    </PanelLayout>
</template>

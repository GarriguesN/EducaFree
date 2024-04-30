<script setup>
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import Table from "@/Components/AdminPanel/Table.vue"
    import { Head, Link, router } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard"/>
    <PanelLayout title="Dashboard">
        <div class="grid gap-5 h-40" :class="$page.props.user.roles.includes('collaborator') || $page.props.user.roles.includes('collaborator') ? 'grid-cols-2' : 'grid-cols-3'">
            <div v-if="$page.props.user.roles.includes('admin')" class="bg-blue-400 p-4 flex justify-center items-center">
                <svg class="mr-5" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <ul>
                    <li class="uppercase text-white text-2xl font-bold">
                        registered users
                    </li>
                    <li class="text-3xl font-black text-white text-center">{{$page.props.usersCount}}</li>
                </ul>
            </div>
            <div class="bg-green-400 p-4 px-5 flex justify-center items-center">
                <svg class="mr-5" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                <ul>
                    <li class="uppercase text-2xl text-white  font-bold">active courses</li>
                    <li class="text-3xl font-black text-white text-center">{{$page.props.coursesCount}}</li>
                </ul>
            </div>
            <div class="bg-red-500 p-4 flex justify-center items-center">
                <svg class="mr-5" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <ul>
                    <li class="uppercase text-2xl text-white font-bold">requests / completed</li>
                    <li class="text-3xl font-black text-white text-center">{{$page.props.requestsCount}} / {{$page.props.completedCount}}</li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-10">
            <div v-if="$page.props.user.roles.includes('admin')" class="bg-slate-50 p-4 flex items-center flex-col">
                <div class="font-bold mb-3">LAST USERS</div>
                <Table :Items="$page.props.lastUsers" :Categorie="'lastUsers'" />
            </div> 
            <div :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'col-span-3' : 'col-span-2'" class="bg-slate-50 p-4 flex items-center flex-col col-span-2">
                <div class="font-bold mb-3">LAST REQUESTS</div>
                <Table :Items="$page.props.lastRequests" :Categorie="'lastRequests'" />
            </div>
        </div>
        <div class="grid grid-cols-3 gap-5 mt-10">
            <div  :class="$page.props.user.roles.includes('editor') || $page.props.user.roles.includes('collaborator') ? 'col-span-3' : 'col-span-2'" class="bg-slate-50 p-4 flex items-center flex-col col-span-2">
                <div class="font-bold mb-3">LAST PENDING COURSES</div>
                <Table :Items="$page.props.lastPending" :Categorie="'lastPending'" />
            </div> 
            <div v-if="$page.props.user.roles.includes('admin')" class="bg-slate-50 p-4 flex items-center flex-col">
                <div class="font-bold mb-3">LAST REPORTS</div>
                <Table :Items="$page.props.lastReports" :Categorie="'lastReports'" />
            </div>
        </div>
    </PanelLayout>
</template>
<template>

<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">

        <div class="flex flex-col">
            <img :src="logo" alt="Logo" class="h-8">
            <span class="self-center text-2xl font-semibold whitespace-nowrap">EducaFree</span>
            <span class="self-center text-2xl font-semibold whitespace-nowrap">{{ $page.props.user.roles[0] }} panel</span>
        </div>    

        <div>
            <ul class="font-medium p-4 mt-4 flex-col justify-between">
            <li v-if="$page.props.user.roles.includes('collaborator')" class="text-center border-b h-max mt-0 border mb-3 bg-blue-700 text-white">
                <NavLink :href="route('uploadAP')" class="!py-5 hover:!font-extrabold hover:!text-white hover:!text-xl">Upload a course</NavLink>
            </li>
            <li class="text-center border-b h-max mt-0">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="!py-5">
                    Dashboard
                </NavLink>
            </li>
            <li class="text-center border-b h-max mt-0">
                <NavLink :href="route('dashboard.courses')" :active="route().current('dashboard.courses')" class="!py-5">
                    {{ $page.props.user.roles.includes('collaborator') ? 'My Accepted Courses' : 'Courses' }}
                </NavLink>
            </li>
            <li class="text-center border-b h-max mt-0">
                <NavLink :href="route('dashboard.pendingCourses')" :active="route().current('dashboard.pendingCourses')" class="!py-5">
                    {{ $page.props.user.roles.includes('collaborator') ? 'My Pending Courses' : 'Pending Courses' }}
                </NavLink>
            </li>
            <li v-if="$page.props.user.roles.includes('admin')" class="text-center border-b  h-max mt-0">
                <NavLink :href="route('dashboard.users')" :active="route().current('dashboard.users')" class="!py-5">
                    Users
                </NavLink>
            </li>
            <li class="text-center border-b  h-max mt-0 ">
                <NavLink :href="route('dashboard.requests')" :active="route().current('dashboard.requests')" class="!py-5">
                    Requests
                </NavLink>
            </li>
            <li v-if="$page.props.user.roles.includes('admin')" class="text-center border-b  h-max mt-0 ">
                <NavLink :href="route('dashboard.reports')" :active="route().current('dashboard.reports')" class="!py-5">
                    Comment Reports
                </NavLink>
            </li>
        </ul>
        </div>

        <div class="flex justify-around mt-5">

            <a :href="route('home')" class="block px-4 py-2 text-sm text-gray-700  cursor-pointer hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-blue-700"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </a>

            <a @click.prevent="logout" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-blue-700"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9"/></svg>
            </a>
        </div>
        
   </div>
</aside>

<div class="p-4 sm:ml-64">
   <slot />
</div>
</template>

<script setup>
    import NavLink from '../NavLink.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import logo from "../../../../public/images/icon/logo.svg";

    //Funcion para cerrar sesion
    const logout = () => {
        router.post(route('logout'));
    };

</script>


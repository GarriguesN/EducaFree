<template>
    <nav :class="[isScrolledDown ? 'shadow-lg' : '', 'fixed w-full z-20 top-0 start-0 bg-white dark:bg-zinc-700 dark:text-white']">
      <div :class="[isScrolledDown ? 'p-6 lg:p-6' : '']" class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-4 px-10 lg:p-10" v-if="canLogin">
        <div class="flex items-center">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-2xl font-semibold whitespace-nowrap">EducaFree</span>
        </div>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-zinc-700 dark:text-white">
                <li>
                    <NavLink :href="route('home')" :active="route().current('home')">
                      Home
                    </NavLink>
                </li>
                <li>
                  <NavLink :href="route('about')" :active="route().current('about')">
                      About Us
                  </NavLink>
                </li>
                <li v-if="$page.props.auth.user">
                  <NavLink :href="route('courses')" :active="route().current('courses')">
                      Courses
                  </NavLink>
                </li>
                <li v-if="$page.props.auth.user">
                  <NavLink :href="route('request')" :active="route().current('request')">
                      Send a request
                  </NavLink>
                </li>
                <li v-if="!$page.props.auth.user">
                    <Link :href="route('login')" class="dark:text-white block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 dark:hover:text-blue-500 md:p-0">Log in</Link>
                </li>
                <li v-if="canRegister && !$page.props.auth.user">
                    <Link  :href="route('register')" class="dark:text-white block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 dark:hover:text-blue-500 md:p-0">Register</Link>
                </li>
                <li v-if="$page.props.auth.user">
                    <!-- Authentication -->
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="flex items-center block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 dark:hover:text-blue-500 md:p-0" type="button" :class="{ 'text-blue-600 dark:text-blue-500': route().current('profile.show') }">{{ $page.props.auth.user.name }} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-md shadow w-44 dark:bg-zinc-700 dark:text-white dark:border dark:border-gray-600">
                        <p class="p-2 text-center">Manage Account</p>
                        <ul class="py-2 text-sm text-gray-700 dark:bg-zinc-700 dark:text-white" aria-labelledby="dropdownInformationButton">
                        <li v-if="$page.props.auth.user && ($page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor')) || $page.props.user.roles.includes('collaborator')">
                                <Link :href="route('dashboard')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Dashboard</Link>
                        </li>
                        <li>
                            <Link :href="route('profile.show')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</Link>
                        </li>
                        </ul>
                        <div class="py-2 dark:bg-zinc-700 dark:text-white">
                            <a @click.prevent="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer dark:text-white dark:hover:bg-gray-600">
                                <form>
                                    <button class="w-max">Log out</button>
                                </form>
                            </a>
                        </div>
                    </div>
                </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { ref, onMounted, onUnmounted } from 'vue';
  import { Head, Link, router } from '@inertiajs/vue3';
  import logo from '../../../../public/images/icon/logo.svg';
  import NavLink from '../NavLink.vue';

  //Definición de props
  defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
  });

  // Función para cerrar sesion
  const logout = () => {
    router.post(route('logout'));
  };
  
  const isScrolledDown = ref(false);

// Function to handle scroll events
function handleScroll() {
  if (window.scrollY > 80) {
    isScrolledDown.value = true;
  } else {
    isScrolledDown.value = false;
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

  </script>

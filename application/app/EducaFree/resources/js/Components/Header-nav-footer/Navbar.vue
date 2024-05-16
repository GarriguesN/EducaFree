<template>
    <nav :class="[isScrolledDown ? 'shadow-lg' : '', 'fixed w-full z-20 top-0 start-0 bg-transparent dark:text-white']">
      <div :class="[isScrolledDown ? 'p-6 lg:p-6' : '']" class="flex bg-white dark:bg-zinc-700 dark:text-white w-full flex-wrap items-center justify-between mx-auto py-4 px-10 lg:p-10" v-if="canLogin">
        <div class="max-w-screen-xl flex bg-white dark:bg-zinc-700 dark:text-white w-full flex-wrap items-center justify-between mx-auto">
        <div class="flex items-center">
          <img :src="logo" alt="Logo" class="h-8 mr-2">
          <span class="self-center text-2xl font-semibold whitespace-nowrap">EducaFree</span>
          <ToggleDark class="ml-2 flex align-top items-start" v-if="cmid == null"></ToggleDark>
        </div>


        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg min-[810px]:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
        </button>

        <div class="hidden w-full min-[810px]:block min-[810px]:w-auto" id="navbar-default">
          <ul class="font-medium flex flex-col p-4 min-[810px]:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 min-[810px]:flex-row min-[810px]:space-x-8 rtl:space-x-reverse min-[810px]:mt-0 min-[810px]:border-0 min-[810px]:bg-white dark:bg-zinc-700 dark:text-white">
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
                <li v-if="$page.props.auth.user && $page.props.auth.user.email_verified_at == null">
                  <p class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:hover:text-blue-500 cursor-pointer" @click="handleLinkClick">
                      Courses
                  </p>
                </li>
                <li v-if="$page.props.auth.user && $page.props.auth.user.email_verified_at != null">
                  <NavLink :href="route('courses')" @click="handleLinkClick" :active="route().current('courses')">
                      Courses
                  </NavLink>
                </li>
                <li v-if="$page.props.auth.user && $page.props.auth.user.email_verified_at == null">
                  <p class="block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:hover:text-blue-500 cursor-pointer" @click="handleLinkClick">
                    Send a request
                  </p>
                </li>
                <li v-if="$page.props.auth.user && $page.props.auth.user.email_verified_at != null">
                  <NavLink :href="route('request')" @click="handleLinkClick" :active="route().current('request')">
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
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="flex items-center block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 dark:border-gray-600 md:hover:text-blue-600 dark:hover:text-blue-500 md:p-0" type="button" :class="{ 'text-blue-600 dark:text-blue-500': route().current('profile.show') }">{{ $page.props.auth.user.name }} 
                    <span class="ml-2 text-sm hidden min-[1023px]:block" :class="[
                      $page.props.user.roles.includes('collaborator') ? 'text-blue-600' : '',
                      $page.props.user.roles.includes('editor') ? 'text-yellow-300' : '',
                      $page.props.user.roles.includes('admin') ? 'text-red-600' : ''
                    ]">
                        {{ $page.props.user.roles[0] }}
                    </span>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"
                    >

                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInformation" class="!z-30 hidden bg-white divide-y divide-gray-100 dark:divide-gray-600 rounded-md shadow w-44 dark:bg-zinc-700 dark:text-white dark:border dark:border-gray-600">
                        <p class="p-2 text-center">Manage Account</p>
                        <span class="text-sm block min-[1023px]:hidden text-center" :class="[
                          $page.props.user.roles.includes('collaborator') ? 'text-blue-600' : '',
                          $page.props.user.roles.includes('editor') ? 'text-yellow-300' : '',
                          $page.props.user.roles.includes('admin') ? 'text-red-600' : ''
                        ]">
                            {{ $page.props.user.roles[0] }}
                        </span>
                        <ul class="py-2 text-sm text-gray-700 dark:bg-zinc-700 dark:text-white" aria-labelledby="dropdownInformationButton">
                        <li v-if="$page.props.auth.user && $page.props.auth.user.email_verified_at == null">
                            <p class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer" @click="handleLinkClick">
                              Dashboard
                            </p>
                        </li>
                        <li v-if="($page.props.auth.user && ($page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor')) || $page.props.user.roles.includes('collaborator')) && $page.props.auth.user.email_verified_at != null">
                                <Link :href="route('dashboard')" @click="handleLinkClick" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Dashboard</Link>
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
      </div>
      <div v-if="$page.props.auth.user != null" class="w-full bg-transparent">
            <AlertVerify v-if="$page.props.auth.user.email_verified_at == null" :glowing="glowing" :status="status"></AlertVerify>
      </div>
    </nav>


    <div v-if="requests && cmid == null">
      <Banner v-if="showIt" class="!fixed !top-36" :class="showIt ? 'block' : 'hidden'" @close="close" @update:glowing="handleLinkClick" :requests="requests"></Banner>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { ref, onMounted, onUnmounted } from 'vue';
  import { Head, Link, router, usePage } from '@inertiajs/vue3';
  import logo from '../../../../public/images/icon/logo.svg';
  import NavLink from '../NavLink.vue';
  import AlertVerify from '@/Components/AlertVerify.vue';
  import Banner from '@/Components/Banner.vue';
  import ToggleDark from  '../ToggleDark.vue';


  //Definición de props
  const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    requests: Array,
    cmid: Number
  });

  // Función para cerrar sesion
  const logout = () => {
    router.post(route('logout'));
  };
  
  const isScrolledDown = ref(false);
  const glowing = ref(false);
  const page = usePage();

// Funcion para el scroll
function handleScroll() {
  if (window.scrollY > 80) {
    isScrolledDown.value = true;
  } else {
    isScrolledDown.value = false;
  }
}

// Funcion para remarcar el aviso
function handleLinkClick() {
  if(page.props.auth.user != null){
      if (page.props.auth.user.email_verified_at == null) {
      // Activar el efecto
      glowing.value = true;

      // Delay para que el brillo desaparezca
      setTimeout(() => {
        glowing.value = false;
      }, 1000); 
    }
  }
}

const showBannerKey = 'showBannerAlert';
const showIt = ref(false);

function checkTimeBanner() {
    const lastTime = localStorage.getItem(showBannerKey);
    const currentTime = new Date().getTime();
    
    if (!lastTime) {
        return true;
    }
    return currentTime - parseInt(lastTime, 10) > 86400000;
}

function showBanner(){
  showIt.value = true;

  // const currentTime = new Date().getTime();
  // localStorage.setItem(showBannerKey, currentTime.toString());
}

function close() {
    showIt.value = false;
    const currentTime = new Date().getTime();
    localStorage.setItem(showBannerKey, currentTime.toString());
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  if(checkTimeBanner()){
    showBanner();
  }else{
  }
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

  </script>

<script setup>
import Card from '../Courses/Card.vue'
import { ref } from  "vue";
import { fetchCourseData } from '@/Pages/Home/services/fetchCoursesData.js';
import { fetchCourseInfoData } from '@/Pages/Home/services/fetchCourseInfoData.js';
import { fetchCourseFavoritesData } from '@/Pages/Home/services/fetchCourseFavoritesData.js';
import Loading from '../Loading.vue';

// Definicion de props
const props = defineProps({
    cmid:{
        type: Number,
        default: null
    },
    coursesMoodle:{
        type: Object
    },
    userId:{
        type: Number
    }
})

// Definicion de varialbes reactivas
const userId = props.userId;
const courses = ref([]);
const courseInfo = ref([]);
const favorites = ref([]);
const searchTerm = ref('');
let isLoading = ref(false);
const activeButton = ref('default');


import { onMounted } from 'vue';
// Función ejecutada cuando el componente se monta al iniciar
onMounted(async () => {
  try {
    // Si se proporcionan cursos de Moodle como prop, se cargaran
    if(props.coursesMoodle != null){
        isLoading.value = true
        courses.value = props.coursesMoodle
        isLoading.value = false;
    }else{ //Si no se cargaran los cursos normales
        isLoading.value = true
        courses.value = await fetchCourseData();
        courseInfo.value = await fetchCourseInfoData(userId)
        favorites.value = await fetchCourseFavoritesData(userId)
        isLoading.value = false;

        CoursesWithInfo(); //Se llama a la función para que se actualicen los datos

    }
  } catch (error) {
    console.error('Error fetching course data:', error);
    isLoading.value = false;
  }
});

// Función asincrónica para filtrar cursos según busqueda
async function filterCourses() {
  try {
        courses.value = await fetchCourseData(searchTerm.value);
        CoursesWithInfo()
  } catch (error) {
        console.error('Error filtering course data:', error);
  }
}

// Función para recoger los últimos curso visitados
function getLastVisitedCourse() {
  const lastVisitedCourse = localStorage.getItem('last_visited_course');
  return lastVisitedCourse ? JSON.parse(lastVisitedCourse) : null;
}

// Función para unir cursos, informacion de cursos y favoritos, para mostrarlos en la vista de forma mas sencilla
function CoursesWithInfo() {
    const courseInfoTrue = courseInfo.value.courseInfo;
    const courseFavoritesTrue = favorites.value.favorites;
    
    if (Array.isArray(courseInfoTrue) && Array.isArray(courseFavoritesTrue)) {
        courses.value = courses.value.map(course => {
            const info = courseInfoTrue.find(info => info.course_id === course.id);
            const favorite = courseFavoritesTrue.find(favorite => favorite.course_id === course.id);
            
            return {
                ...course,
                progress: info ? info.progress : null,
                favorite: favorite ? true : false
            };
        }).sort((a, b) => {
            // Ordenar por favoritos primero
            if (a.favorite && !b.favorite) return -1;
            if (!a.favorite && b.favorite) return 1;
            // Si ambos son favoritos o no favoritos, mantener el orden original
            return 0;
        });
    } else {
        console.log('Course info data or favorites data is not an array:', courseInfoTrue, courseFavoritesTrue);
    }
}

// Función para ordenar cursos según un criterio
const orderBy = (criteria) => {
    const courseInfoTrue = courseInfo.value.courseInfo;
    const courseFavoritesTrue = favorites.value.favorites;
    activeButton.value = criteria;
    if (Array.isArray(courseInfoTrue) && Array.isArray(courseFavoritesTrue)) {
        courses.value = courses.value.map(course => {
            const info = courseInfoTrue.find(info => info.course_id === course.id);
            const favorite = courseFavoritesTrue.find(favorite => favorite.course_id === course.id);
            
            return {
                ...course,
                progress: info ? info.progress : null,
                favorite: favorite ? true : false
            };
        }).sort((a, b) => {
            switch (criteria) {
                case 'default':
                    if (a.favorite && !b.favorite) return -1; // Ordenar por favoritos primero
                    if (!a.favorite && b.favorite) return 1;

                case 'length':
                    return b.name.length - a.name.length; // Ordenar por longitud, de mayor a menor
                case 'shortest':
                    return a.name.length - b.name.length; // Ordenar por longitud, de menor a mayor
                case 'alphabeticalA':
                    return a.name.localeCompare(b.name); // Ordenar alfabéticamente
                case 'alphabeticalZ':
                return b.name.localeCompare(a.name); // Ordenar alfabéticamente al reves
                case 'date':
                    return new Date(b.created_at) - new Date(a.created_at); 
                    // Ordenar por fecha, de más reciente a más antigua
                default:
                    console.error('Invalid criteria:', criteria);
                    return 0; // Mantener el orden original en caso de criterio inválido
            }
        });
    } else {
        console.error('Course info data or favorites data is not an array:', courseInfoTrue, courseFavoritesTrue);
    }
}
</script>

<template>
    <section v-if="cmid == null" class="min-[560px]:h-[22rem] bg-white h-[24rem] border-b-2 dark:border-gray-600 flex justify-end content-center flex-col shadow-lg dark:bg-zinc-700 dark:text-white">
        <p class="text-center text-7xl font-[1000] mb-5">Courses</p>

        <div v-if="cmid == null" class="justify-between grid-cols-2 grid">
            <div class="m-5 grid-cols-1 col-span-2 lg:col-span-1">
                <form class="mx-auto" @submit.prevent="filterCourses">   
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                            fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" v-model="searchTerm" @input="filterCourses" 
                        class="block w-full ps-10 text-sm text-gray-900
                        border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-600
                        dark:border-gray-600 dark:text-gray-200" 
                        placeholder="Search..." required />
                    </div>
                </form>
            </div>
            
            <div class="grid-cols-2 flex items-center hidden lg:flex md:items-center">
                <p v-if="getLastVisitedCourse() != null" class="block w-full ps-10 p-[8px] text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 mr-5 font-bold flex-row dark:bg-zinc-700 dark:text-white dark:border-gray-600">
                    Last visited
                    <a :href="'/course/' + getLastVisitedCourse().id">
                        <span class="ml-8 font-normal">{{ getLastVisitedCourse().name }}</span>
                    </a>
                </p>
            </div>  
        </div>
        <div v-if="cmid == null" class="flex-col mx-auto mt-3 w-4/5">
            <div class="grid grid-cols-2 min-[560px]:grid-cols-3 auto-rows-max min-[910px]:grid-cols-6 justify-center mb-1">
                <button @click="orderBy('default')" :class="{ 'bg-blue-700 dark:text-white text-white hover:bg-blue-700 hover:text-white': activeButton === 'default', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900  hover:bg-gray-100 hover:text-blue-700': activeButton !== 'default' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700 focus:z-10 focus:ring-gray-100">Default</button>
                <button @click="orderBy('length')" :class="{ 'bg-blue-700  dark:text-white text-white hover:bg-blue-700 hover:text-white': activeButton === 'length', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900 hover:bg-gray-100 hover:text-blue-700': activeButton !== 'length' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700 focus:z-10 focus:ring-gray-100">Longest</button>
                <button @click="orderBy('shortest')" :class="{ 'bg-blue-700  dark:text-white text-white hover:bg-blue-700 hover:text-white': activeButton === 'shortest', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900  hover:bg-gray-100 hover:text-blue-700': activeButton !== 'shortest' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700  focus:z-10 focus:ring-gray-100">Shortest</button>
                <button @click="orderBy('alphabeticalA')" :class="{ 'bg-blue-700  dark:text-white-700 text-white hover:bg-blue-700 hover:text-white': activeButton === 'alphabeticalA', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900  hover:bg-gray-100 hover:text-blue-700': activeButton !== 'alphabeticalA' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700 focus:z-10 focus:ring-gray-100">A to Z</button>
                <button @click="orderBy('alphabeticalZ')" :class="{ 'bg-blue-700  dark:text-white-700 text-white hover:bg-blue-700 hover:text-white': activeButton === 'alphabeticalZ', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900  hover:bg-gray-100 hover:text-blue-700': activeButton !== 'alphabeticalZ' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700 focus:z-10 focus:ring-gray-100">Z to A</button>
                <button @click="orderBy('date')" :class="{ 'bg-blue-700 dark:text-white text-white hover:bg-blue-700 hover:text-white': activeButton === 'date', 'bg-white dark:bg-zinc-700 dark:text-white text-gray-900 hover:bg-gray-100 hover:text-blue-700': activeButton !== 'date' }" class="py-1.5 px-8 me-2 mb-2 text-sm font-medium focus:outline-none rounded-full border border-blue-700 focus:z-10 focus:ring-gray-100">Date</button>
            </div>
        </div>
    </section>

    <section id="courses" class="dark:bg-zinc-700 dark:text-white">
    <div class="container px-5 py-8 mx-auto sm:px-1 ">
        <div class="gap-4 grid grid-flow-row-dense">
            <div class="col-span-3 flex justify-center md:flex md:justify-around">
                <div v-if="courses.length > 0" class="grid grid-cols-1 min-[770px]:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 xl:m-auto gap-x-[4rem] 2xl:gap-x-36  gap-y-10 justify-items-center items-center">  
                    <Card v-for="course in courses" :course="course" :cmid="cmid ? cmid : null"/>
                </div>
                <div v-if="courses.length == 0 && isLoading == false" class="">
                    <p class="text-2xl text-black mt-10 text-gray-400">No courses found!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<Loading :loading="isLoading"></Loading>
</template>

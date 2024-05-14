<script setup>
import Modal from '../../Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import FormUpdate from "@/Components/Profile/updateInfo.vue";
import FormPassword from "@/Components/Profile/updatePassword.vue";
import FormDeleteAccount from  "@/Components/Profile/deleteAccount.vue"
import {ref} from  "vue";
import { fetchRankingData } from '../Profile/services/fetchRankigData';

// Definicion de props
const props = defineProps({
    sessions: Array,
    coursesInfo: Object,
    userRank: Number,
    favorites: Object
});

// Definicion de forms
const form = useForm({
    name: '',
    email: '',
});

const formPassword = useForm({
    currentPassword: '',
    newPassword: '',
    repeatPassword: ''
})

const formDelete = useForm({
    id: '',
})

// Definicion de variables reactivas
let showModal = ref(false);
let Items = ref([]);
const courses = ref([]);
const favs = ref([]);
favs.value = props.favorites
courses.value = props.coursesInfo

// Funcion para saber cuantos cursos completos tienes
function getCompletedCourses(){
    return courses.value.filter(course => course.progress == 100).length || '0' 
}

// Funcion para saber cuantos cursos favoritos tienes
function getFavs(){
    return favs.value.length;
}

// Funcion para abrir el modal
const openModal = async ()  => {
    Items.value = await fetchRankingData();
    showModal.value = true;
};

// Funcion para recoger las horas totales que has estado en los cursos
function getHours(){
    let totalHours = 0;

    courses.value.forEach(course => {
        const info = course;

        // Verificar si hay información del curso
        if (info) {
            // Calcular el tiempo total completado para este curso en minutos
            const totalTimeMinutes = (info.progress / 100) * info.course.lessons_count * 15;

            // Convertir los minutos a horas y sumar al total
            totalHours += totalTimeMinutes / 60;
        }
    });

    // Retornar el total de horas completadas redondeado a dos decimales
    return totalHours.toFixed(2);
}
</script>

<template>
    <Head title="Profile" />
    <Layout title="Profile">
        <div class="pb-10">
            <section class="mx-auto bg-white h-[37rem] sm:h-[22rem] flex justify-end content-center flex-col shadow-lg dark:bg-zinc-700 dark:text-white">
                <p class="mt-5 mb-10 text-center text-4xl font-[1000]">Welcome to your profile <span></span>{{ $page.props.auth.user.name }} !</p>
                <div class="flex flex-col sm:flex-row justify-around p-4 ">
                    <div class="flex flex-col items-center justify-center">
                        <div class="mb-2 text-3xl font-extrabold">{{courses.length}}</div>
                        <div class="text-gray-500 dark:text-gray-200">Started Courses</div>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                            <div class="mb-2 text-3xl font-extrabold">{{ getCompletedCourses() }}</div>
                            <div class="text-gray-500 dark:text-gray-200">Completed Courses</div>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                            <div class="mb-2 text-3xl font-extrabold">{{ getFavs() }}</div>
                            <div class="text-gray-500 dark:text-gray-200">Favorites Courses</div>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <div class="mb-2 text-3xl font-extrabold">~ {{ getHours() }} hr</div>
                            <div class="text-gray-500 dark:text-gray-200">Time Learning</div>
                        </div>
                        <div class="flex flex-col items-center justify-cente dark:bg-zinc-700r">
                            <div v-if="userRank == 1" class="mb-2 text-5xl md:text-5xl text-amber-400 font-extrabold">{{ userRank }}</div>
                            <div v-else-if="userRank == 2" class="mb-2 text-5xl text-slate-300 font-extrabold">{{ userRank }}</div>
                            <div v-else-if="userRank == 3" class="mb-2 text-5xl text-amber-600 font-extrabold">{{ userRank }}</div>
                            <div v-else-if="userRank > 3" class="mb-2 text-5xl  font-extrabold">{{ userRank }}</div>
                            <div v-else class="mb-2 text-5xl font-extrabold">NR</div>
                            <div class="text-blue-500 cursor-pointer underline" @click="openModal">Ranking</div>
                        </div>
                </div>
            </section>
        </div>
        <div class="container px-5 py-8 mx-auto dark:bg-zinc-700 dark:text-white max-w-[80rem]">
            <section id="updateInfo" class="border-b dark:border-gray-600 p-2">
                <FormUpdate :form="form" @submit="form.put(route('user.update', $page.props.auth.user.id))" :name="$page.props.auth.user.name" :email="$page.props.auth.user.email" />
            </section>
            <section id="updatePassword" class="border-b dark:border-gray-600 p-2">
                <FormPassword :form="formPassword" @submit="formPassword.put(route('user.updatePassword', $page.props.auth.user.id))" />
            </section>
            <section id="deleteUser" class="p-2">
                <FormDeleteAccount :form="formDelete" @submit="formDelete.delete(route('user.deleteYourself', $page.props.auth.user.id))" />
            </section>
        </div>

        <Modal :show="showModal" @close="showModal = false" maxWidth="md">
            <a @click="showModal=false" class="hover:text-red-500 cursor-pointer  dark:hover:text-red-500 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left  text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Ranking
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            Completed Courses
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="Items.length > 0" v-for="(item, index) in Items" class="odd:bg-white even:bg-gray-50 border-b dark:border-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap " :class="{
                        'bg-yellow-200': index === 0, 
                        'bg-slate-200': index === 1, 
                        'bg-amber-600': index === 2, 
                        'text-gray-900': index > 2}">
                            {{ index + 1}}
                        </th>
                        <td class="px-6 py-4">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ item.courses_info_count }}
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="px-6 py-4 text-center">
                            Nothing to show here!
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </Modal>

    </Layout>
</template>

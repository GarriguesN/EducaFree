<script setup>
import { Link } from '@inertiajs/vue3';
import Modal from '../Modal.vue';
import {useForm} from '@inertiajs/vue3';
import Form from './FormLesson.vue';
import FormPoint from './FormPoint.vue';
import FormCourse from './FormCourse.vue';
import FormPDF from './FormPDF.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

// Definición de props
const props = defineProps({
    course: {
        type: Object,
        required: true
    },
    lessons: {
        type: Object,
        required: true
    },
    points: {
        type: Object,
        required: true
    }
});


// Declaración de variables reactivas
let showModalDelete = ref(false);
let id = ref ('');
let showModal = ref(false);
let updating = ref(false);
let showModalPoint = ref(false);
let showModalCourse = ref(false);
let showModalPDF = ref(false);
let categorie = ref('');
let imagen = ref('');


// Funciones para mostrar modal de eliminacion
const openDelete = (selectedId, cat) => {
        id.value = selectedId;
        categorie.value = cat;
        showModalDelete.value = true;
        console.log(id.value)
};

// Declaración de formularios y lógica de formularios
const form = useForm({
    name : '',
    description: '',
    id: '',
})

const formPoint = useForm({
    name : '',
    explanation: '',
    id: '',
})

const formCourse = useForm({
    name : '',
    description: '',
    id: '',
    img: null,
    edited: false
})

const formDataPDF = useForm({
    file: null,
    id: ''
})

// Funciones para abrir modales de creación y edición
const newLesson = () => {
    form.name = '';
    form.description = '';
    updating = false
    showModal.value = true;
};

const newPoint = (id) => {
    formPoint.name = '';
    formPoint.explanation = '';
    formPoint.id = '';
    updating = false
    showModalPoint.value = true;
    formPoint.id = id;
};

const newPDF = (id) => {
    formDataPDF.file = null;
    formDataPDF.id = '';
    updating = false
    showModalPDF.value = true;
    formDataPDF.id = id;
};

const editPDF = (id) => {
    formDataPDF.file = null;
    formDataPDF.id = '';
    updating = true
    showModalPDF.value = true;
    formDataPDF.id = id;
};

// Funciones para agregar y eliminar elementos al curso 
const addLesson = () => {
        form.post(route('course.addLesson', props.course.id))
        showModal.value = false;
}

const addPoint = () => {
    const lessonId = formPoint.id;
    const courseId = props.course.id;
    formPoint.post(route('course.addPoint', { id: lessonId, courseId: courseId }));
    showModalPoint.value = false;
}

const addPDF = () => {
    const lessonId = formDataPDF.id;
    const courseId = props.course.id;
    formDataPDF.post(route('course.addPDF', { id: lessonId, courseId: courseId }));
    showModalPDF.value = false;
}

const deleteLesson = () => {
    const courseId = props.course.id;
    router.delete(route('course.deleteLesson', { id: id.value, courseId: courseId }))
    showModalDelete.value=false

}

const deletePoint = () => {
    const courseId = props.course.id;
    router.delete(route('course.deletePoint', { id: id.value, courseId: courseId }))
    showModalDelete.value=false
}

const deletePDF = () => {
    const courseId = props.course.id;
    router.post(route('course.deletePDF', { id: id.value, courseId: courseId }))
    showModalDelete.value=false

}

// Funciones para abrir modales de edición
const openEditCourse = (name, description, id, img) => {
    console.log(description);
    console.log(name);
    console.log(id);
    formCourse.name = name;
    formCourse.description = description;
    formCourse.id = id
    console.log(img)
    imagen.value = img;
    console.log(imagen.value)
    showModalCourse.value = true;
};

const openEditPoint = (name, explanation, id) => {
    formPoint.name = name;
    formPoint.explanation = explanation;
    formPoint.id = id
    updating = true
    showModalPoint.value = true;
};

const openEditLesson = (name, description, id) => {
    form.name = name;
    form.description = description;
    form.id = id
    updating = true
    showModal.value = true;
};

// Funciones para actualizar los elementos del curso
const editLesson = () => {
    const lessonId = form.id;
    const courseId = props.course.id;
    const lessonData = {
        _method: 'put', // Especificamos el método PUT aquí ya que no laravel no lo soporta
        name: form.name,
        description: form.description
    };
    router.post(route('course.editLesson', { id: lessonId, courseId: courseId }), lessonData);
    showModal.value = false;
}

const editPoint = () => {
    const pointId = formPoint.id;
    const courseId = props.course.id;
    const lessonData = {
        _method: 'put', // Especificamos el método PUT aquí ya que no laravel no lo soporta
        name: formPoint.name,
        explanation: formPoint.explanation
    };
    router.post(route('course.editPoint', { id: pointId, courseId: courseId }), lessonData);
    showModalPoint.value = false;
}

const editCourse = () => {
    const courseId = formCourse.id;
    const lessonData = {
        _method: 'put', // Especificamos el método PUT aquí ya que no laravel no lo soporta
        name: formCourse.name,
        description: formCourse.description,
        img: formCourse.img,
        edited: formCourse.edited,
    };
    router.post(route('course.editCourse', { id: courseId}), lessonData);
    showModalCourse.value = false;
}

const autoURL = window.location.origin;
const urlBase = `${autoURL}/storage/ImagesCourses/`;
</script>

<template>
  <Modal :show="showModalDelete" @close="showModalDelete = false" maxWidth="sm">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-white dark:hover:text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-200">Are you sure you want to delete it?</h3>
                    <button v-if="categorie.includes('lesson')" @click="deleteLesson" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="categorie.includes('point')" @click="deletePoint" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="categorie.includes('pdf')" @click="deletePDF" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                <button @click="showModalDelete=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">No, cancel</button>
            </div>
    </Modal>    


    <section class="relative">
        <div class="grid">
            <div class="col-span-1 flex flex-col items-center justify-center row">
                <div class="flex flex-col justify-center items-center" v-if="course.img">
                    <img class="w-[10rem]" :src="urlBase+course.img">
                    <p class="text-center mt-2 text-sm text-gray-400">Image preview</p>
                </div>
                <div class="text-center mt-2 text-sm text-gray-400" v-else>No image loaded</div>
                <h2 class="text-3xl text-center text-black mt-8 font-bold dark:text-white">{{ course.name }}</h2>
                <h4 class="text-xl text-center text-black mt-8 font-bold dark:text-white">{{ course.description }}</h4>
            </div>
            <p @click="openEditCourse(course.name, course.description, course.id, course.img)" class="m-3 text-blue-600 hover:text-blue-800 cursor-pointer flex justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</p>
        </div>
    </section>

    <section id="lessons" class="min-h-[50vh]">
    <div class="container px-5 py-16 mx-auto sm:px-20">
      <div class="md:flex w-full h-full">
        <div class="border-b border-gray-200 min-w-52 dark:border-gray-600">
          <ul class="flex-col text-sm font-medium text-gray-500 md:me-4 md:mb-0 min-w-full"
                        id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-blue-700 dark:text-blue-500 hover:text-blue-700 border-blue-700"
                        data-tabs-inactive-classes="text-gray-500 dark:text-gray-200 hover:text-gray-600 border-gray-100 hover:border-gray-300 dark:border-gray-600"
                        role="tablist">
            <li v-for="(lesson, index) in $page.props.lessons" :key="index" class="me-2" role="presentation">
              <button @click="activateTab(index)"
                      :class="{ 'border-blue-700': activeTab === index }"
                      class="p-4 border-b-2 rounded-t-lg w-full flex justify-between" :id="'lesson-tab-' + index"
                      :data-tabs-target="'#lesson-content-' + index" type="button" role="tab"
                      :aria-controls="'lesson-content-' + index"
                      :aria-selected="activeTab === index">{{index+1}}. {{ lesson.name }}
                      <div>
                        <p @click="openEditLesson(lesson.name, lesson.description, lesson.id)" class="text-blue-600 hover:text-blue-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg></p>
                        <p @click="openDelete(lesson.id, 'lesson')" class="text-red-600 hover:text-red-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></p>
                      </div>
                    </button>
                
            </li>
            <li @click="newLesson" class="me-2 mt-5 flex cursor-pointer text-green-500 hover:text-green-800 mb-5 justify-center" role="presentation">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                New lesson
            </li>
          </ul>
        </div>

        <Modal :show="showModal" @close="showModal = false">
            <a @click="showModal=false" class="hover:text-red-500 cursor-pointer dark:text-white dark:hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <div class="">
                <Form :form="form" @submit="updating ? editLesson() : addLesson()" :updating="updating"></Form>
            </div>
        </Modal>

        <Modal :show="showModalPoint" @close="showModalPoint = false"> 
            <a @click="showModalPoint=false" class="hover:text-red-500 cursor-pointer dark:text-white dark:hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <FormPoint :form="formPoint" @submit="updating ? editPoint() : addPoint()" :updating="updating"></FormPoint>
        </Modal>

        <Modal :show="showModalCourse" @close="showModalCourse = false">
            <a @click="showModalCourse=false" class="hover:text-red-500 cursor-pointer dark:text-white dark:hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <FormCourse :form="formCourse" @submit="editCourse" :updating="true" :image="imagen"></FormCourse>
        </Modal>

        <Modal :show="showModalPDF" @close="showModalPDF = false">
            <a @click="showModalPDF=false" class="hover:text-red-500 cursor-pointer dark:text-white dark:hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <FormPDF :form="formDataPDF" @submit="addPDF" :updating="updating"></FormPDF>
        </Modal>


        <div id="default-styled-tab-content" class="bg-gray-50 text-medium text-gray-500 rounded-lg w-full max-w-[90%] dark:bg-zinc-600">
          <div v-if="$page.props.lessons.length > 0" v-for="(lesson, index) in $page.props.lessons" :key="index"
               :class="{ hidden: activeTab !== index }" class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-600 max-w-full"
               :id="'lesson-content-' + index" role="tabpanel"
               :aria-labelledby="'lesson-tab-' + index">
                <div v-for="(point, pointIndex) in lesson.points" :key="pointIndex" class="max-w-full mb-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white border-b dark:border-gray-400 mb-2">{{ point.name }}</h3>
                    <div class="explanation text-justify text-gray-600 dark:text-gray-200 break-words" v-html="point.explanation"></div>
                    <div class="flex">
                        <p @click="openEditPoint(point.name, point.explanation, point.id)" class="text-blue-600 hover:text-blue-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg></p>
                        <p @click="openDelete(point.id, 'point')" class="text-red-600 hover:text-red-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></p>
                    </div>
                </div>
                <div class="max-w-full mb-4">
                    <p @click="newPoint(lesson.id)" class="me-2 mt-5 flex cursor-pointer text-green-500 hover:text-green-800 mb-5" role="presentation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                        New point
                    </p>
                </div>
                <div v-if="lesson.pdf_url != null" class="border-t border-gray-200 flex">
                    <a :href="lesson.pdf_url" class="italic text-blue-400 hover:text-blue-700 mr-2">PDF: {{ lesson.name }}</a>
                    <p @click="editPDF(lesson.id)" class="text-blue-600 hover:text-blue-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg></p>
                    <p @click="openDelete(lesson.id, 'pdf')" class="text-red-600 hover:text-red-800 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></p>
                </div>
                <div v-else class="border-t border-gray-200">
                    <p @click="newPDF(lesson.id)" class="me-2 mt-5 flex cursor-pointer text-green-500 hover:text-green-800 mb-5" role="presentation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                        Add PDF
                    </p>
                </div>
          </div>
          <div v-else class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-600 max-w-full">
            <p class="dark:text-gray-200">Nothing here yet</p>
          </div>
        </div>
      </div>
    </div>
  </section>

</template>

<script>
export default {
    data() {
        return {
            // Se inicia el índice de la pestaña activa como 0
            activeTab: 0
        };
    },
    methods: {
        // Método para activar una pestaña específica
        activateTab(index) {
            // Se actualiza el índice de la pestaña activa con el índice, haciendo que cambie de estilo
            this.activeTab = index;
        }
    }
};
</script>

<style>
.explanation h1, .explanation h2, .explanation h3, .explanation h4, .explanationh5, .explanation h6 {
    font-size: revert;
}

.explanation blockquote, .explanation dl, .explanation dd, .explanation h1, .explanation h2, .explanation h3, .explanation h4, .explanation h5, .explanation h6, .explanation hr, .explanation figure, .explanation p, .explanation pre{
    margin: revert;
    padding: revert;
    margin-top: 1px;
}

.explanation code{
    background-color: black;
    color: white;
    padding: 0.25rem 0.5rem;
    font-size: 0.85em;
    border-radius: 0.25rem;
    font-family: 'Source Code Pro', monospace;
    font-weight: 400;
}

.explanation blockquote{
    border-left: 0.25rem solid #dfe2e5;
    padding: 0 1.25rem;
    border-radius: 0.25rem;
    font-style: italic;
}

.explanation ol, .explanation ul, .explanation menu {
    margin: revert;
    padding: revert;
    list-style: revert;
}

.explanation ol li, .explanation ul li, .explanation menu li {
    margin: revert;
    padding: revert;
}

.explanation ol li:before, .explanation ul li:before, .explanation menu li:before {
    content: revert;
}

.explanation img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
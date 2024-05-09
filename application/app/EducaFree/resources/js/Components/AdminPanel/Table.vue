<script setup>
    import Modal from '../Modal.vue';
    import  {ref} from "vue";
    import { router } from '@inertiajs/vue3'
    import {useForm} from '@inertiajs/vue3';
    import Form from './FormCourse.vue';
    
    //Definicion de los props
    defineProps({
        Items: {
            type: Object,
            required: true
        },
        Categorie: {
            type: String,
            required: true
        }
    });

    //Declararión de formulario
    const form = useForm({
        name : '',
        description: '',
        id: '',
        img: null
    })
    
    // Declaración de variables reactivas
    let showModal = ref(false);
    let showModalCourse = ref(false)
    let selectedItem = ref(null);
    let updating = ref(false);
    const id = ref(null);
    const reportId = ref(null);
    const typeComment = ref(null);
    let showModalDelete = ref(false);
    let showModalWarning = ref(false);
    const selectedRole = ref(null);
    let showModalRemove = ref(false);

    // Función para abrir un modal y recoger el item selecionado
    const openModal = (item) => {
        showModal.value = true;
        selectedItem.value = item;
    };

    // Función para abrir un modal de confirmación de eliminación
    const openDelete = (selectedId, extra=null, report = null) => {
        // Si hay información adicional se asignan a las variables
        if(extra != null){
            typeComment.value = extra;
            reportId.value = report
        }

        id.value = selectedId;
        showModalDelete.value = true;
    };

    // Función para abrir un modal de advertencia
    const openWarning = (selectedId, option) => {
        id.value = selectedId;
        selectedRole.value = option;
        showModalWarning.value = true;
        console.log(selectedRole.value);    
        console.log(selectedRole.value == option); 
    };


    // Función para abrir un modal de eliminaciónes
    const openRemove = (selectedId) => {
        id.value = selectedId;
        showModalRemove.value = true
    }

    // Función para realizar una solicitud de eliminación de un elemento
    const deleteRequest = () => {
            router.delete(route('request.delete', id.value))
            showModalDelete.value  = false
            id.value = null;
    }

    // Función para realizar una solicitud de eliminación de un usuario
    const deleteUser = () => {
            router.delete(route('user.delete', id.value))
            showModalDelete.value  = false
            id.value = null;
    }

    // Función para realizar una solicitud de eliminación de un curso
    const deleteCourse = () => {
            router.delete(route('course.delete', id.value))
            showModalDelete.value  = false
            id.value = null;
    }

    // Función para realizar una solicitud de eliminación de un comentario
    const deleteComment = () => {
            router.delete(route('report.delete', {id: reportId.value, idComment: id.value, type: typeComment.value }))
            showModalDelete.value  = false
            id.value = null;
            typeComment.value=null;
            reportId.value = null
    }

    // Función para completar un request
    const complete = id => {
        router.put(route('request.complete', id))
    }

    // Función para permitir un reporte de un comentario
    const pass = id => {
        router.delete(route('report.pass', id))
    }

    // Función para editar las lecciones de un curso
    const getLessons = id => {
        router.get(route('dashboard.course', id))
    }

    // Función para ver una vista previa de un curso
    const getView = id => {
        router.get(route('dashboard.preview', id))
    }

    // Función para crear un nuevo curso
    const newCourse = () => {
        form.name = '';
        form.description = '';
        updating = false
        showModalCourse.value = true;
    };

    // Función para agregar el curso creado
    const addCourse = () => {
        form.post(route('dashboard.addCourse'))
        showModalCourse.value = false;
    };

    // Función para hacer invisible un curso
    const visionoff = (id) => {
        router.put(route('course.visioff', id))
    }

    // Función para hacer visible un curso
    const visionon = (id) => {
        router.put(route('course.vision', id))
    }

    // Función para dar el rol de administrador a un usuario
    const giveAdmin = () => {
        router.post(route('user.giveAdmin', id.value))
        showModalWarning.value  = false
        id.value = null;
    }

    // Función para dar el rol de editor a un usuario
    const giveEditor = () => {
        router.post(route('user.giveEditor', id.value))
        showModalWarning.value  = false
        id.value = null;
    }

    const giveCollaborator = () => {
        router.post(route('user.giveCollaborator', id.value))
        showModalWarning.value  = false
        id.value = null;
    }

    // Función para eliminar los roles de un usuario
    const deleteRoles = () => {
        router.post(route('user.deleteRoles', id.value))
        showModalRemove.value  = false
        id.value = null;
    }

    // Función para aceptar un curso subido por un 'uploader'
    const accept = (idSelected) => {
        router.post(route('course.accept', idSelected))
    }
    
</script>

<template>
<Modal :show="showModal" :closeable="true">
    <a @click="showModal=false" class="hover:text-red-500 dark:text-white dark:hover:text-red-500 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </a>
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
        <h3 class="text-xl font-semibold text-gray-900  ">
            {{selectedItem.title}}
        </h3>
    </div>

    <div class="p-4 md:p-5 space-y-4">
        <p class="text-base leading-relaxed text-gray-500  ">
            {{selectedItem.description}}
        </p>
    </div>
</Modal>

<Modal :show="showModalCourse" @close="showModalCourse = false">
            <a @click="showModalCourse=false" class="hover:text-red-500 dark:text-white dark:hover:text-red-500 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <Form :form="form" @submit="addCourse"></Form>
</Modal>


<Modal :show="showModalDelete" @close="showModalDelete = false" maxWidth="sm">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-white dark:hover:text-red-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500  ">Are you sure you want to delete it?</h3>
                    <button v-if="Categorie.includes('request')" @click="deleteRequest" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="Categorie.includes('users')" @click="deleteUser" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="Categorie.includes('courses') || Categorie.includes('pendingCourses')" @click="deleteCourse" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="Categorie.includes('reports')" @click="deleteComment" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                <button @click="showModalDelete=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100           ">No, cancel</button>
            </div>

</Modal>

<Modal :show="showModalWarning" @close="showModalWarning = false" maxWidth="sm">
    
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-white dark:hover:text-red-500  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500  ">Are you sure you want to give permissions?</h3>
                    <button v-if="selectedRole == 'admin'" @click="giveAdmin" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, give permission</button>
                    <button v-else-if="selectedRole == 'editor'" @click="giveEditor" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, give permission</button>
                    <button v-else @click="giveCollaborator" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, give permission</button>
                <button @click="showModalWarning=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100           ">No, cancel</button>
            </div>

</Modal>

<Modal :show="showModalRemove" @close="showModalRemove = false" maxWidth="sm">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-white dark:hover:text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500  ">Are you sure you want to remove all permissions?</h3>
                    <button @click="deleteRoles" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300   font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, remove all</button>
                <button @click="showModalRemove=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100           ">No, cancel</button>
            </div>

</Modal>


<div v-if="Categorie.includes('request')" class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50    border-b     pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  "  @click="openModal(item)">
                    {{ item.title }}
                </th>
                <td class="px-6 py-4"  @click="openModal(item)">
                    {{ item.description }}
                </td>
                <td v-if="item.completed == 0" class="px-6 py-4">
                    <a @click="complete(item.id)" class="font-medium text-blue-600 hover:underline m-2 cursor-pointer">Done</a>
                    <a v-if="$page.props.user.roles.includes('admin')" @click="openDelete(item.id)" href="#" class="font-medium text-red-600 hover:underline cursor-pointer">Delete</a>
                </td>
                <td v-else class="px-6 py4">
                    <p class="font-medium text-grey-400 hover:underline m-2">Completed</p>
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


<div v-if="Categorie.includes('reports')" class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Comment
                </th>
                <th scope="col" class="px-6 py-3">
                    Reason
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50 border-b pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ item.data.comment }}
                </th>
                <td class="px-6 py-4">
                    {{ item.reason }}
                </td>
                <td class="px-6 py-4">
                    <a @click="pass(item.id)" class="font-medium text-blue-600 hover:underline m-2 cursor-pointer">Pass</a>
                    <a v-if="$page.props.user.roles.includes('admin')" @click="openDelete(item.data.id, item.data.type, item.id)" href="#" class="font-medium text-red-600 hover:underline cursor-pointer">Delete Comment</a>
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


<div v-if="Categorie.includes('users')" class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Mail
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Give rol
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    remove all roles
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white even:bg-gray-50    border-b     pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  ">
                    {{ item.id }}
                </th>
                <td class="px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="px-6 py-4">
                    {{ item.email }}
                </td>
                <td class="px-6 py-4">
                    {{ item.roles[0] ? item.roles[0].name : 'user'}}
                </td>
                <td v-if="!item.roles[0]" class="px-6 py-4 text-center flex justify-evenly">
                    <a v-if="(item.roles[0] && !item.roles[0].name.includes('admin')) || !item.roles[0]" @click="openWarning(item.id, 'admin')" href="#" class="font-medium text-red-600 hover:underline cursor-pointer">Admin</a>
                    <a v-if="(item.roles[0] && !item.roles[0].name.includes('editor'))  || !item.roles[0]" @click="openWarning(item.id, 'editor')" href="#" class="font-medium text-yellow-400 hover:underline cursor-pointer">Editor</a>
                    <a v-if="(item.roles[0] && !item.roles[0].name.includes('collaborator'))  || !item.roles[0]" @click="openWarning(item.id, 'collaborator')" href="#" class="font-medium text-blue-600 hover:underline cursor-pointer">Collaborator</a>
                </td>
                <td v-else class="px-6 py-4 text-center flex justify-evenly">
                    No roles to assign
                </td>
                <td class="px-6 py-4 text-center">
                    <a v-if="item.roles[0]" @click="openRemove(item.id)" href="#" class="font-medium text-red-600 hover:underline cursor-pointer">Remove</a>
                </td>
                <td class="px-6 py-4">
                    <a v-if="$page.props.user.roles.includes('admin')" @click="openDelete(item.id)" href="#" class="font-medium text-red-600 hover:underline cursor-pointer">Delete</a>
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

<div v-if="Categorie.includes('lastRequests')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50    border-b     pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  ">
                    {{ item.title }}
                </th>
                <td class="px-6 py-4">
                    {{ item.description }}
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

<div v-if="Categorie.includes('lastPending')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50    border-b     pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  ">
                    {{ item.name }}
                </th>
                <td class="px-6 py-4">
                    {{ item.description }}
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

<div v-if="Categorie.includes('lastReports')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Comment
                </th>
                <th scope="col" class="px-6 py-3">
                    Reasson
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50    border-b     pointer">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  ">
                    {{ item.data.comment }}
                </th>
                <td class="px-6 py-4">
                    {{ item.reason }}
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

<div v-if="Categorie.includes('lastUsers')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50    border-b     pointer">
                <td class="px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="px-6 py-4">
                    {{ item.email }}
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

<div v-if="Categorie.includes('courses')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 10 && ($page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor'))">
                <td colspan="5" class="px-6 py-4 text-center">
                    <p class="flex justify-center cursor-pointer text-green-500 hover:text-green-800 m-2" @click="newCourse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                        Add course
                    </p>
                </td>
            </tr>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50 border-b pointer">
                <td class="px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="px-6 py-4">
                    {{ item.description }}
                </td>
                <td class="px-6 py-4 flex">
                    <a @click="getLessons(item.id)" href="#" class="font-medium mr-2 text-blue-600 hover:underline cursor-pointer">Edit</a>
                    <a @click="openDelete(item.id)" href="#" class="font-medium mr-2 text-red-600 hover:underline cursor-pointer">Delete</a>
                    <a v-if="item.vision == 1" @click="visionoff(item.id)"  href="#" class="font-medium pl-2 text-gray-600 hover:text-gray-800 cursor-pointer border-l"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 16.01C14.2091 16.01 16 14.2191 16 12.01C16 9.80087 14.2091 8.01001 12 8.01001C9.79086 8.01001 8 9.80087 8 12.01C8 14.2191 9.79086 16.01 12 16.01Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M2 11.98C8.09 1.31996 15.91 1.32996 22 11.98" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M22 12.01C15.91 22.67 8.09 22.66 2 12.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></a>
                    <a v-else @click="visionon(item.id)" href="#" class="font-medium pl-2 text-gray-600 hover:text-gray-800 cursor-pointer border-l"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.83 9.17999C14.2706 8.61995 13.5576 8.23846 12.7813 8.08386C12.0049 7.92926 11.2002 8.00851 10.4689 8.31152C9.73758 8.61453 9.11264 9.12769 8.67316 9.78607C8.23367 10.4444 7.99938 11.2184 8 12.01C7.99916 13.0663 8.41619 14.08 9.16004 14.83" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 16.01C13.0609 16.01 14.0783 15.5886 14.8284 14.8384C15.5786 14.0883 16 13.0709 16 12.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.61 6.39004L6.38 17.62C4.6208 15.9966 3.14099 14.0944 2 11.99C6.71 3.76002 12.44 1.89004 17.61 6.39004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M20.9994 3L17.6094 6.39" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.38 17.62L3 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M19.5695 8.42999C20.4801 9.55186 21.2931 10.7496 21.9995 12.01C17.9995 19.01 13.2695 21.4 8.76953 19.23" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></a>
                </td>
            </tr>
            <tr v-else>
                <td colspan="5" class="px-6 py-4 text-center">
                    Nothing to show here!
                </td>
            </tr>
            <tr>
                <td v-if="$page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor')" colspan="5" class="px-6 py-4 text-center">
                    <p class="flex justify-center cursor-pointer text-green-500 hover:text-green-800 m-2" @click="newCourse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                        Add course
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div v-if="Categorie.includes('pendingCourses')" class="relative overflow-x-auto shadow-md sm:rounded-lg w-full h-full">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500  ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50    ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="Items.length > 0" v-for="item in Items" class="odd:bg-white  even:bg-gray-50 border-b pointer">
                <td class="px-6 py-4">
                    {{ item.name }}
                </td>
                <td class="px-6 py-4">
                    {{ item.description }}
                </td>
                <td v-if="item.revision_status !== 'approved'" class="px-6 py-4 flex">
                    <a @click="getView(item.id)" href="#" class="font-medium mr-2 text-blue-600 hover:underline cursor-pointer">View</a>
                    <a v-if="$page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor')" @click="accept(item.id)" href="#" class="font-medium mr-2 text-green-600 hover:underline cursor-pointer">Accept</a>
                    <a v-if="$page.props.user.roles.includes('admin') || $page.props.user.roles.includes('editor')" @click="openDelete(item.id)" href="#" class="font-medium mr-2 text-red-600 hover:underline cursor-pointer">Delete</a>
                    <p v-else class="font-medium text-grey-300 hover:underline">Pending...</p>
                </td>
                <td v-else class="px-6 py4">
                    <p class="font-medium text-grey-400 hover:underline m-2">Accepted</p>
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

</template>

<script>
    export default {
        components: {
            Modal,
        },
        setup() {
            return {
                showModal,
                selectedItem,
                openModal,
            };
        },
    };
</script>
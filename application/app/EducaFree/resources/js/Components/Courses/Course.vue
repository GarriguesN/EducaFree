<script setup>
import Form from "@/Components/Courses/FormComment.vue";
import { fetchCourseCommentsData } from "@/Pages/Courses/services/fetchCourseCommentsData";
import { router, useForm, usePage } from '@inertiajs/vue3';
import Modal from '../Modal.vue';
import Pagination from "@/Components/Pagination.vue";
import { ref, onMounted, onUnmounted, watch } from 'vue';


//Definición de los props
const props = defineProps({
    course: {
        type: Object,
        required: true
    },
    cmid :{
        type: String
    }
});

//Definición de las variables
const comments = ref([]);
const countComments = ref(0);
const idCourse = ref(props.course.id)
let id = ref();
let type = ref('');
const replyVisible = ref(false);
const editVisibleComment = ref(false);
const editVisibleReply = ref(false);
let isLoading = ref(false);
let showModalDelete = ref(false);
let showModalReport = ref(false);
const pageProp = usePage();
const open = ref(false);
const chat = ref([]);
const textChat = ref('');
const thinking = ref(false);
const change = ref(false);

//Definición de los formularios
const form = useForm({
    comment: '',
    id: props.course.id
})

const formReply = useForm({
    comment: '',
    id: props.course.id
})

const formEditComment = useForm({
    comment: '',
    id: props.course.id
});

const formEditReply = useForm({
    comment: '',
    id: props.course.id
});

// Función para agregar un comentario a un curso
const addComment = () => {
    form.post(route('course.comment', form.id),{
        preserveScroll: true,
        preserveState: true
    })
    
}

//Funcion para contestar el comentario (commentId)
const replyComment = (commentId) => {
    formReply.post(route('course.replyComment', commentId),{
        preserveScroll: true,
        preserveState: true
    })
}

// Función asíncrona para obtener los comentarios del curso
const getResults = async (page = 1) => {
    isLoading.value = true;
    const response = await fetchCourseCommentsData(props.course.id, page, 5, pageProp.props.auth?.user?.id);
    comments.value = await response
    countComments.value = await response.total ;
    isLoading.value = false;
}

// Ejecutar la funcion
getResults();

// Abrir el form para contestar
const openReply = (id) => {
    replyVisible.value = id;
}

// Abrir el form para editar el comentario
const openEditComment = (id, comment) => {
    editVisibleComment.value = id;
    editVisibleReply.value = false;
    formEditComment.comment = comment;
}

// Abrir el form para editar la respuesta
const openEditReply = (id, comment) => {
    editVisibleReply.value = id;
    editVisibleComment.value = false;
    formEditReply.comment = comment;
}

// Funcion para enviar el comentario editado
const editComment = (commentId) => {
    formEditComment.put(route('course.editComment', commentId),{
        preserveScroll: true,
        preserveState: true
    })
}

// Funcion para eliminar el comentario
const deleteComment = () => {
    let idComment = id.value
    router.delete(route('course.deleteComment', { id: idComment, idCourse: idCourse.value }),{
        preserveScroll: true,
        preserveState: true
    })
    showModalDelete.value  = false
    id.value = null;
}

// Funcion para eliminar la respuesta
const deleteReply = () => {
    let idReply = id.value
    router.delete(route('course.deleteReply', { id: idReply, idCourse: idCourse.value }), {
        preserveScroll: true,
        preserveState: true
    })
    showModalDelete.value  = false
    id.value = null;
}

// Funcion para enviar la respuesta editada
const editReply = (replyId) => {
    formEditReply.put(route('course.editReply', replyId),{
        preserveScroll: true,
        preserveState: true
    })
}

// Funcion para saber si es una respuesta
const isReply = (reply) => {
    return reply.hasOwnProperty('comment_id');
};

// Funcion para abrir el modal de eliminar
const openDelete = (selectedId, selectedType) => {
    id.value = selectedId;
    showModalDelete.value = true;
    type.value = selectedType;
};

// Funcion para abrir el modal de reportar
const openReport = (selectedId, selectedType) => {
    id.value = selectedId;
    type.value = selectedType;
    showModalReport.value = true;
}

//Funcion para enviar el reporte a la base de datos
const postReport = (idR, typeR, reasonR) => {
    router.post(route('comment.report', { id: idR, type: typeR, reason: reasonR }),{},{
        preserveScroll: true,
        preserveState: true
    })
    showModalReport.value = false;
}

//Funcion para volver atras
const back = () => {
    window.history.back()
}

//Si solo hay una lesson en el curso, se actualiza el progreso a 100%
if(usePage().props.lessons.length == 1){
    let progress = 100;
            axios.post(`/course/updateInfo/${props.course.id}`, { progress: progress })
                .catch(error => {
                    console.error('Error:', error);
                });
}

const favorite = (id) => {
    router.post(route('comments.addFavorites', [id, idCourse.value]), {}, {
        preserveScroll: true,
        preserveState: true
    })
}

const openSide = () => {
open.value = !open.value;
change.value = !change.value;
}

const sendPrompt = async () => {
    if(textChat.value.trim() == ''){
        alert('No puedes enviar un comentario vacío');
        return
    }else{
        chat.value.push({ message: textChat.value , sender: 'You'});
        let prompt = textChat.value
        textChat.value = '';
        thinking.value = true
        try {
            // Fetch the AI response
            console.log(textChat.value)
            const aiResponse = await fetchChatAiData(prompt);

            // Add the AI's response to the chat
            chat.value.push({ message: aiResponse, sender: 'AI' });

            // Clear the text input
            thinking.value = false
        } catch (error) {
            console.error('Error fetching AI data:', error);
        }
        
    }
}

</script>

<template>
    <!-- CABECERA -->
    <section class="bg-white h-[21rem] flex justify-end content-center flex-col shadow-lg dark:bg-zinc-700">
        <div @click="back" class="cursor-pointer m-4 ml-10 mb-10 text-blue-700 dark:text-blue-500 dark:hover:text-white hover:text-black w-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M19 12H6M12 5l-7 7 7 7"/></svg>
        </div>
        <p class="text-center text-5xl font-[1000] mb-10">{{ course.name }}</p>
    </section>

    <!-- LECCIONES -->
    <section id="lessons">
        <div class="container px-5 py-16 mx-auto sm:px-20">
            <div class="md:flex h-full" :class="open ? 'w-[70rem]': 'w-full'">
                <div class="border-b border-gray-200 min-w-52 dark:border-gray-600" :class="open ? 'w-[20rem]': ''">
                    <ul class="flex-col text-sm font-medium text-gray-500 md:me-4 md:mb-0 min-w-full"
                        id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-blue-700 dark:text-blue-500 hover:text-blue-700 border-blue-700"
                        data-tabs-inactive-classes="text-gray-500 dark:text-gray-200 hover:text-gray-600 border-gray-100 hover:border-gray-300 dark:border-gray-600"
                        role="tablist">
                        <li v-for="(lesson, index) in $page.props.lessons" :key="index" class="me-2"
                            role="presentation">
                            <button @click="activateTab(index, $page.props.lessons.length, $page.props.course.id)"
                                :class="{ 'border-blue-700': activeTab === index }"
                                class="inline-block p-4 border-b-2 rounded-t-lg w-full" :id="'lesson-tab-' + index"
                                :data-tabs-target="'#lesson-content-' + index" type="button" role="tab"
                                :aria-controls="'lesson-content-' + index"
                                :aria-selected="activeTab === index">{{ index + 1 }}. {{ lesson.name }}</button>
                        </li>
                    </ul>

                </div>
                <div id="default-styled-tab-content"
                    class="bg-gray-50 text-medium text-gray-500 rounded-lg w-full max-w-full dark:bg-zinc-600" :class="open ? 'w-[80rem]': 'w-full'">
                    <div v-if="$page.props.lessons.length > 0" v-for="(lesson, index) in $page.props.lessons" :key="index"
                        :class="{ hidden: activeTab !== index }" class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-600 max-w-full"
                        :id="'lesson-content-' + index" role="tabpanel" :aria-labelledby="'lesson-tab-' + index">
                        <div v-for="(point, pointIndex) in lesson.points" :key="pointIndex" class="max-w-full mb-4">
                            <h3 class="text-lg font-medium text-gray-800 dark:text-white border-b dark:border-gray-500 mb-2 w-full">{{ point.name }}</h3>
                            <div class="explanation text-justify text-gray-600 dark:text-gray-200" v-html="point.explanation"></div>
                        </div>
                        <div v-if="lesson.pdf_url != null || lesson.content_url != null"
                            class="border-t border-gray-200 flex flex-col">
                            <a v-if="lesson.pdf_url != null" :href="lesson.pdf_url"
                                class="italic text-blue-400 hover:text-blue-700">PDF: {{ lesson.name }}</a>
                            <a v-if="lesson.content_url != null" :href="content_url"
                                class="italic text-blue-400 hover:text-blue-700">Content: {{ lesson.name }}</a>
                        </div>
                        <div v-else class="border-t border-gray-200">
                            <p class="text-justify text-gray-300">No extra content</p>
                        </div>
                    </div>
                    <div v-else class="p-4 rounded-lg bg-gray-50 dark:bg-zinc-600 max-w-full">
                        <p class="dark:text-gray-200">Nothing here yet</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHAT -->
    <div class="hidden min-[1300px]:block">
        <button @click="openSide" id="chatButton" type="button" class="absolute top-[336px] right-5 inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg hover:text-blue-700  dark:text-gray-400 dark:hover:text-blue-500">
            <span v-if="!change" class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <p class="mx-2">Chat with AI</p>
            </span>
            <span v-else id="closeSpan" class="inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="hover:text-red-600" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                <p class="mx-2">Close chat</p>
            </span>
            
        </button>

        <aside
            :class="open ? '  opacity-100 -translate-x-0 block' : ' opacity-0 -translate-x-full hidden'"
            class="absolute top-[385px] right-5 z-40 w-[30rem] h-[689px] transition-all delay-700 duration-500 ease-in"
        >
            
            <div class="h-full px-3 py-5 pt-0.5 border dark:border-gray-600 bg-gray-50 dark:bg-zinc-700">
                <p class="text-xs text-gray-600 text-center dark:text-gray-300">Chat history will be automatically deleted when you leave this course</p>
                <!-- CHAT -->
                <div class="h-[92%]  px-3 py-4 overflow-y-auto shadow-inner border dark:border-gray-600 bg-white dark:bg-zinc-600 dark:shadow-inner">
                    <div v-for="message in chat" class="text-wrap flex flex-col gap-1 w-full mt-1 ">
                        <div class="flex items-center space-x-2 ">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{message.sender}}</span>
                        </div>
                        <div class="flex flex-col leading-1.5 w-full p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-zinc-700">
                            <p v-if="message.message.type=='error' && message.message.AI" class="break-words text-sm flex font-normal text-red-700 dark:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                {{message.message.response}}
                            </p>
                            <p v-if="message.message.AI && message.message.type=='ok'" class="break-words text-sm font-normal text-gray-900 dark:text-white">{{message.message.response}} </p>
                            <p v-if="!message.message.AI" class="break-words text-sm font-normal text-gray-900 dark:text-white" :class="message.type ? 'text-red-600':''">{{message.message}} </p>
                        </div>
                    </div>

                </div>
                <div class="relative w-full my-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" class="absolute left-3 top-1/2 size-4 -translate-y-1/2 fill-blue-700 dark:fill-blue-500">
                        <path fill-rule="evenodd" d="M5 4a.75.75 0 0 1 .738.616l.252 1.388A1.25 1.25 0 0 0 6.996 7.01l1.388.252a.75.75 0 0 1 0 1.476l-1.388.252A1.25 1.25 0 0 0 5.99 9.996l-.252 1.388a.75.75 0 0 1-1.476 0L4.01 9.996A1.25 1.25 0 0 0 3.004 8.99l-1.388-.252a.75.75 0 0 1 0-1.476l1.388-.252A1.25 1.25 0 0 0 4.01 6.004l.252-1.388A.75.75 0 0 1 5 4ZM12 1a.75.75 0 0 1 .721.544l.195.682c.118.415.443.74.858.858l.682.195a.75.75 0 0 1 0 1.442l-.682.195a1.25 1.25 0 0 0-.858.858l-.195.682a.75.75 0 0 1-1.442 0l-.195-.682a1.25 1.25 0 0 0-.858-.858l-.682-.195a.75.75 0 0 1 0-1.442l.682-.195a1.25 1.25 0 0 0 .858-.858l.195-.682A.75.75 0 0 1 12 1ZM10 11a.75.75 0 0 1 .728.568.968.968 0 0 0 .704.704.75.75 0 0 1 0 1.456.968.968 0 0 0-.704.704.75.75 0 0 1-1.456 0 .968.968 0 0 0-.704-.704.75.75 0 0 1 0-1.456.968.968 0 0 0 .704-.704A.75.75 0 0 1 10 11Z" clip-rule="evenodd" />
                    </svg>
                    <input v-if="!thinking" type="text" v-model="textChat" class="w-full border-outline bg-white border border-gray-200 rounded-xl px-2 py-2.5 pl-10 pr-24 text-sm text-slate-700 l disabled:cursor-not-allowed disabled:opacity-75 dark:border-gray-700 dark:bg-zinc-600 dark:text-gray-300" name="prompt" placeholder="Ask AI ..." />
                    <input v-else type="text" disabled class="w-full border-outline bg-white border border-gray-200 rounded-xl px-2 py-2.5 pl-10 pr-24 text-sm text-slate-700 l disabled:cursor-not-allowed disabled:opacity-75 dark:border-gray-700 dark:bg-zinc-600 dark:text-gray-300" name="prompt" placeholder="Thinking..." />
                    <button v-if="!thinking" @click="sendPrompt" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer bg-blue-700 rounded-xl px-2 py-1 text-xs tracking-wide text-slate-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2  active:opacity-100 active:outline-offset-0 dark:bg-blue-600 dark:text-slate-100 dark:focus-visible:outline-blue-600">Send</button>
                    <button v-else @click="sendPrompt" type="button" disabled class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer bg-blue-700 rounded-xl px-2 py-1 text-xs tracking-wide text-slate-100 transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2  active:opacity-100 active:outline-offset-0 dark:bg-blue-600 dark:text-slate-100 dark:focus-visible:outline-blue-600">
                        <div class="animate-spin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                        </div>
                    </button>
                </div>
            </div>
        </aside>
    </div>


    </section>

    <!-- COMENTARIOS -->
    <div v-if="cmid == null">
        <section v-if="$page.props.auth?.user?.email_verified_at != null" class="bg-white border-t-2 flex justify-end content-center flex-col shadow-lg dark:bg-zinc-700 dark:border-gray-600">
        <div class="border-b dark:border-gray-600">
            <Form :form="form" @submit="addComment"></Form>
        </div>
        <div v-if="countComments > 0" class="w-full flex flex-col justify-center m-auto ">
            <div>
                <p class="text-center text-2xl p-5 bg-gray-100 dark:bg-zinc-600">{{ countComments }} Comments in total</p>
            </div>

            <div v-for="comment in comments.data" :key="comment.id" class="p-4 text-base bg-white dark:bg-zinc-700 w-[80%] m-auto">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 text-xl font-semibold dark:text-white">
                            {{ comment.user.name }}
                        </p>
                        <p class="text-sm text-gray-600 items-center dark:text-gray-300">
                            {{ new Date(comment.created_at).toDateString() }}
                        </p>
                    </div>
                    <div class="flex justify-center items-center">
                        <div v-if="($page.props.auth.user.roles && $page.props.auth.user.roles[0]?.name || 'none') === 'admin' || $page.props.auth.user.id == comment.user_id" class="flex items-center text-sm text-gray-400 dark:text-gray-300">
                            <p @click="openEditComment(comment.id, comment.comment)" class="m-1 hover:text-blue-700 cursor-pointer">Edit</p>
                            <p>/</p>
                            <p @click="openDelete(comment.id, 'comment')" class="m-1 hover:text-red-700 cursor-pointer">Delete</p>
                        </div>
                        <div v-else class="flex items-center text-sm  text-gray-400">
                            <p @click="openReport(comment.id, 'comment')" class="m-1 hover:text-black cursor-pointer">Report</p>
                        </div>
                        <!-- Add the favorite button here -->
                        <button @click="favorite(comment.id)" class="m-1 text-red-700 hover:text-red-500 cursor-pointer">
                            <svg v-if="comment.is_favorited" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linecap="square"
                                stroke-linejoin="bevel">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </button>

                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ comment.favorites_count }} Likes</p>
                    </div>
                    
                </div>
                <p class="text-gray-500 dark:text-gray-200" :class="editVisibleComment === comment.id   ? 'hidden' : ''">{{ comment.comment }}</p>
                <Form v-if="editVisibleComment === comment.id" :form="formEditComment" @submit="editComment(comment.id)" :edit="true"></Form>
                <div class="flex items-center mt-4 space-x-4">
                    <button type="button" @click="openReply(comment.id)"
                        class="flex items-center text-sm text-gray-500 dark:text-gray-300 hover:underlinefont-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 ml-2" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="square" stroke-linejoin="bevel">
                            <path d="M10 16l-6-6 6-6" />
                            <path d="M20 21v-7a4 4 0 0 0-4-4H5" />
                        </svg>
                        Reply
                    </button>
                </div>
                <Form v-if="replyVisible === comment.id" :form="formReply" @submit="replyComment(comment.id)"
                    :reply="true">
                </Form>
                    
                <div v-if="comment.replies.length > 0" class="border-b dark:border-gray-600 p-2">
                    <div v-for="reply in comment.replies" :key="reply.id" class="p-2 text-base bg-white dark:bg-zinc-700 w-[80%] m-auto">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white text-xl font-semibold">
                                    {{ reply.user.name }}
                                </p>
                                <p class="text-sm text-gray-600 items-center dark:text-gray-300">
                                    {{ new Date(reply.created_at).toDateString() }}
                                </p>
                            </div>
                            <div v-if="($page.props.auth.user.roles && $page.props.auth.user.roles[0]?.name || 'none') === 'admin' || $page.props.auth.user.id == reply.user_id" class="flex items-center text-sm text-gray-400 dark:text-gray-300">
                                <p @click="openEditReply(reply.id, reply.comment)" class="m-1 hover:text-blue-700 cursor-pointer">Edit</p>
                                <p>/</p>
                                <p @click="openDelete(reply.id, 'reply')" class="m-1 hover:text-red-700 cursor-pointer">Delete</p>
                            </div>
                            <div v-else class="flex items-center text-sm text-gray-400">
                                <p @click="openReport(reply.id, 'reply')" class="m-1 hover:text-black cursor-pointer">Report</p>
                            </div>
                        </div>
                        <p class="text-gray-500 dark:text-gray-300" :class="editVisibleReply === reply.id && isReply(reply) ? 'hidden' : ''">{{ reply.comment }}</p>
                        <Form v-if="editVisibleReply === reply.id && isReply(reply)" :form="formEditReply" @submit="editReply(reply.id)" :edit="true"></Form>
                    </div>
                </div>
                
            </div>
        </div>
        <div v-else class=" flex-col m-auto">
            <p class="text-xl pt-10 text-center">No comments!</p>
            <p class="text-lg pb-10 text-gray-400 text-center">Be the first!</p>
        </div>
        
        <Pagination v-if="countComments > 0"
            :pagination="comments"
            @pagination-change-page="getResults"
        />

    </section>
    </div>
    


    <a class="fixed end-6 bottom-1 md:bottom-6 z-50  group" :href="'/course/pdf/' + course.id" v-if="$page.props.auth?.user?.email_verified_at != null">
        <button type="button" data-tooltip-placement="left"
            class="flex justify-center items-center w-[52px] h-[52px] dark:bg-zinc-700 dark:text-gray-200 text-gray-500 hover:text-blue-700 bg-white rounded-full border border-gray-200 shadow-sm hover:bg-gray-50">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path d="M5 20h10a1 1 0 0 0 1-1v-5H4v5a1 1 0 0 0 1 1Z" />
                <path
                    d="M18 7H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-1-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3h14Z" />
            </svg>
            <span class="sr-only">Export to PDF</span>
        </button>
    </a>

    <div v-if="isLoading == true"
        class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-full bg-gray-800 bg-opacity-50">
        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>
    </div>


    <Modal :show="showModalDelete" @close="showModalDelete = false" maxWidth="sm">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-200">Are you sure you want to delete it?</h3>
                    <button v-if="type == 'comment'" @click="deleteComment(id.value)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                    <button v-if="type == 'reply'" @click="deleteReply(id.value)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, delete</button>
                <button @click="showModalDelete=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
            </div>
    </Modal>

    <Modal :show="showModalReport" @close="showModalReport = false" maxWidth="md">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500  dark:text-gray-200">Report Reason</h3>
                <div class="m-auto flex justify-center justify-around">
                    <button @click="postReport(id, type, 'Troll')" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Troll</button>
                    <button @click="postReport(id, type, 'Bad Words')" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Bad Words</button>
                    <button @click="postReport(id, type, 'Offensive')" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Offensive</button>
                    <button @click="postReport(id, type, 'Spam')" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Spam</button>
                </div>
                <button @click="showModalReport=false" type="button" class="mt-5 py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
            </div>
    </Modal>

</template>

<script>
import { ref } from 'vue';
import axios from "axios";
import { fetchChatAiData } from "./services/fetchChatAiData";

export default {
    data() {
        return {
            activeTab: ref(0) // Usando ref para reactive data
        };
    },
    methods: {
        activateTab(index, totalLessons, courseId) {
            console.log(this.props);
            this.activeTab = index;
            let lastLesson = index + 1;

            let progress = (lastLesson / totalLessons) * 100;

            axios.post(`/course/updateInfo/${courseId}`, { progress: progress })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
};
</script>

<style>
#chatButton:hover #closeSpan svg {
    stroke: red;
}

#chatButton:hover #closeSpan p {
    color: rgb(63, 131, 248); 
}

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
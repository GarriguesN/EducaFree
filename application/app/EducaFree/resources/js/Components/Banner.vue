<script setup>
    import { ref } from 'vue';
    import Modal from '../Components/Modal.vue';
    import axios from 'axios';
    import { usePage } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';

    const page = usePage();

    const emit = defineEmits(['close', 'update:glowing'])

    const props = defineProps({
        requests: Array
    })

    let showModal = ref(false);
    let showModalDelete = ref(false);
    const id = ref('')
    const idPendingCourse = ref();
    const title = ref('')
    const description = ref('')

    // Función para abrir el modal
    const openModal = () => {
        showModal.value = true;
    };

    const openModalDelete = () => {
        showModalDelete.value = true;
    };

    const checkPending = async (userId) => {
    try {
        // Make an API call to check for a pending course
        const response = await axios.get(`/api/courses/pending`, {
            params: {
                userId: userId, // Use the userId argument
            },
        });

        // Determine if there is a pending course
        const hasPendingCourse = response.data.hasPendingCourses;
        return hasPendingCourse
    } catch (error) {
        // Log the error and handle it as appropriate
        console.error('Error checking for pending course:', error);
    }
};


    const start = async (idSelected, nameSelected, descriptionSelected) => {
        idPendingCourse.value = null;
        const user = page.props.auth?.user;
        const isLoggedIn = user !== null;
        const isVerified = user?.email_verified_at !== null;

        if (!isLoggedIn) {
            router.get(route('login'));
            return;
        }

        if (!isVerified) {
            showModal.value = false;
            emit('update:glowing', true);
            console.log('glowing');

            // Set a timeout to reset glowing after 1 second (adjust as needed)
            setTimeout(() => {
                emit('update:glowing', false);
            }, 1000);

            return;
        }

        id.value = idSelected;
        title.value = nameSelected;
        description.value = descriptionSelected;
        const coursepending = await checkPending(page.props.auth.user.id)
        if(coursepending == null){
            router.get(await route('upload'), {title: title.value, description: description.value}, {
                preserveState: true,
                preserveScroll: true,
            });
        }else{
            openModalDelete();
            idPendingCourse.value = coursepending.id;
        }
    }

    const confirm = async () => {
        try {
            
            const response = await fetch(route('pendingcourse.deletenew'), {
                method: 'GET', 
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            
            if (response.ok) {
                const result = await response.json();

                if (result.ok) {
                    showModalDelete.value = false;
                    showModal.value = false
                    await start(id.value, title.value, description.value);
                } else {
                    console.error('Pending course could not be deleted');
                }
            } else {
                console.error('Error in request, status code:', response.status);
            }
        } catch (error) {
            console.error('Error during deletion:', error);
        }
    };

</script>

<template>
    <div id="marketing-banner" tabindex="-1"
        class="fixed z-50 top-36 flex flex-col md:flex-row-reverse justify-between w-[calc(100%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-200 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-blue-600">
        <div class="items-center justify-end flex flex-shrink-0 flex-end">
            <button data-dismiss-target="#marketing-banner" @click="$emit('close')" type="button"
                class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col mb-3 me-4 md:items-center md:flex-row md:mb-0 text-center justify-center items-start">
            <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-300">New Requests! We have
                course creation requests that need your expertise. Help us complete them and shape our platform. <span
                    class="ml-2 underline hover:font-bold hover:text-blue-700 hover:dark:text-white cursor-pointer"
                    @click="openModal">Click here to get started!</span></p>
        </div>
    </div>

    <Modal :show="showModal" @close="showModal = false" maxWidth="2xl">
        <div class="p-4 md:p-5 text-center max-h-[92vh]">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 mb-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Requests
                </h3>
                <button @click="showModal = false" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="timeline-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <div class="h-[80vh] overflow-y-auto">
                <ul class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <li v-for="request in requests" class="flex flex-row pb-3">
                    <div
                        class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg group dark:text-white w-full">
                        <p
                            class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 ms-3 whitespace-nowrap text-balance w-[20%]">
                            {{ request.title }}</p>
                        <p class="text-lg font-semibold flex-1 ms-3 whitespace-nowrap text-balance hyphens-auto truncate w-[70%]"
                            lang="en">{{ request.description }}</p>
                        <span @click="start(request.id, request.title, request.description)"
                            class="w-[10%] inline-flex items-center justify-self-end px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-500 dark:text-gray-300 hover:bg-blue-700 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white">Start
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="12" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h13M12 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </Modal>


    <Modal :show="showModalDelete" @close="showModalDelete = false" maxWidth="sm">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-white dark:hover:text-red-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-300  ">You have a pending course. If you continue, the course will be deleted and cannot be restored. Please proceed with caution.</h3>
                    <p class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-300">You can check <a class="text-blue-500 font-bold hover:underline cursor-pointer" :href="route('upload')">here</a> your pending course</p>
                    <button @click="confirm" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-blue-600 rounded-lg border border-blue-700 hover:bg-blue-500 hover:text-black focus:z-10 focus:ring-4 focus:ring-gray-100">Continue</button>
                    <button @click="showModalDelete=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
                </div>

    </Modal>
</template>

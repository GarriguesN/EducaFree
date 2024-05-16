<script setup>
import FormSection from '../FormSection.vue';
import InputError from '../InputError.vue';
import InputLabel from '../InputLabel.vue';
import PrimaryButton from '../PrimaryButton.vue';
import TextInput from '../TextInput.vue';
import Modal from '../Modal.vue';
import { ref } from "vue";

// Definición de props
const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    updating: {
        type: Boolean,
        required: false,
        default: false
    },
    image: {
        type: String,
    }
});

// Declaración de una variable reactiva para controlar el modal
let showModal = ref(false);
let option = ref(true);
let image = ref(props.image);
const fileName = ref(image);
const originalFileName = ref('');
const errorMessage = ref('');

// Función para abrir el modal
const openModal = (error) => {
    option.value = error;
    showModal.value = true;
};

// Definir un evento para emitir el formulario
const emits = defineEmits(["submit"]);

// Funcion para convertir una url a imagen
function dataURLtoBlob(dataURL) {
    const parts = dataURL.split(';base64,');
    const contentType = parts[0].split(':')[1];
    const raw = window.atob(parts[1]);
    const rawLength = raw.length;
    const uInt8Array = new Uint8Array(rawLength);

    for (let i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], { type: contentType });
}

// Función para manejar la carga de imágenes
const handleImageUpload = (event) => {

    option.value = true;
    const file = event.target.files[0]; // Accede al archivo seleccionado
    const allowedExtensions = ["png", "jpg", "jpeg"]; // Extensiones permitidas

    // Verifica si se seleccionó un archivo
    if (file) {
        originalFileName.value = file.name;
        const extension = file.name.split('.').pop().toLowerCase(); // Obtiene la extensión del archivo
        // Verifica si la extensión es PNG o JPG
        if (!allowedExtensions.includes(extension)) {
            // Abre el modal si la extensión no está permitida
            openModal(true);
            event.target.value = ''; // Limpia el valor del campo de carga de archivos
        } else {
            const reader = new FileReader();
            // Cuando el archivo se cargue, lea el contenido y lo asigne a la propiedad img del formulario
            reader.onload = (e) => {

                const img = new Image();
                img.src = e.target.result;

                img.onload = () => {
                    image.value = originalFileName.value;
                    fileName.value = image.value
                    console.log(image.value)
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const maxWidth = 920;
                    const maxHeight = 520;
                    let width = img.width;
                    let height = img.height;

                    if (width >= maxWidth || height >= maxHeight) {
                        const aspectRatio = width / height;
                        if (width > height) {
                            width = maxWidth;
                            height = width / aspectRatio;
                        } else {
                            height = maxHeight;
                            width = height * aspectRatio;
                        }
                        
                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);

                        // Convierte el canvas en una imagen data URL
                        const resizedDataURL = canvas.toDataURL('image/jpeg');
                        console.log(resizedDataURL);


                        const blob = dataURLtoBlob(resizedDataURL);

                        const resizedFile = new File([blob], originalFileName, { type: 'image/png' });

                        // Asigna la imagen redimensionada al formulario
                        props.form.img = resizedFile;

                    }else{
                        openModal(false);
                        event.target.value = '';
                    }
                }
            };
            reader.readAsDataURL(file); // Lector de archivos
        }
    }
}

const deleteImg = () => {
    image.value = null;
    props.form.img = null;
    fileName.value = ""
    props.form.edited = true;
}

const openFileInput = () => {
    const fileInput = document.getElementById('fileInput');
    fileInput.click();
};

const checkFields = () => {
    let nameEmpty = !props.form.name;
    let descriptionEmpty = !props.form.description;

    if (nameEmpty && descriptionEmpty) {
        errorMessage.value = 'Please fill Name and Description fields';
    } else if (nameEmpty) {
        errorMessage.value = 'Please fill Name field';
    } else if (descriptionEmpty) {
        errorMessage.value = 'Please fill Description field';
    } else {
        emits('submit');
    }

    if (nameEmpty || descriptionEmpty) {
        setTimeout(() => {
            errorMessage.value = '';
        }, 2000);
    }
}
</script>

<template>
    <div class="container px-5 py-8 mx-auto sm:px-20">
    <FormSection @submitted="checkFields()">
        <template #title>
            {{ updating ? 'Edit course': 'New course'}}
        </template>

        <template #description>
            {{ updating ? 'Edit the selected course': 'Add a new course'}}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <input type="hidden" v-model="form.id">
                <InputLabel for="name" value="Name"/>
                <TextInput id="name" v-model="form.name" type="text" autocomplete="lesson-name" class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.name" class="mt-2"/>

                <InputLabel for="description" value="Description" class="mt-3"/>
                <textarea id="description" v-model="form.description" autocomplete="course-description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-zinc-600 dark:border-gray-600 rounded-md shadow-sm w-full" rows="4"></textarea>
                <InputError :message="$page.props.errors.description" class="mt-2"/>

                <InputLabel for="img" value="Image" class="mt-3"/>
                <div class="flex">
                    <button @click.prevent="openFileInput" class="border border-gray-300 bg-gray-100 hover:bg-blue-700 dark:bg-gray-400 dark:hover:bg-blue-700 dark:text-gray-800 hover:text-white dark:hover:text-white rounded-s-md p-2">Choose Image</button>
                    <input type="text" :value="fileName" readonly class="border-gray-300 rounded-e-md dark:bg-zinc-600 shadow-sm w-[70%]">
                    <input type="file" style="display: none" id="fileInput" ref="fileInput" @change="handleImageUpload">

                    <button @click.prevent="deleteImg" class="flex items-center text-sm hover:text-red-600" v-if="image">
                        <span class="ml-2 text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </span>
                        Remove current
                    </button>
                </div>
                
            </div>
        </template>
        
            <template #actions>
                <InputError :message="errorMessage" class="mr-2 mt-2"/>
                <PrimaryButton class="mt-2">
                    {{ updating ? "Edit" : "Add" }} 
                </PrimaryButton>
            </template>
            
    </FormSection>
</div>

<Modal :show="showModal" @close="showModal = false" maxWidth="sm">
    <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500" v-if="option">Only images!</h3>
                <h3 class="mb-5 text-lg font-normal text-gray-500" v-else>The image must be at least 920 x 520 pixels. Please upload a larger image.</h3>
                <button @click="showModal=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Ok</button>
        </div>
</Modal>

</template>

<style>

</style>
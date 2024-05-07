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
});

// Declaración de una variable reactiva para controlar el modal
let showModal = ref(false);
let option = ref(true);
// Función para abrir el modal
const openModal = (error) => {
    option.value = error;
    showModal.value = true;
};

// Definir un evento para emitir el formulario
defineEmits(["submit"]);

// Función para manejar la carga de imágenes
const handleImageUpload = (event) => {
    console.log('works');
    option.value = true;
    const file = event.target.files[0]; // Accede al archivo seleccionado
    const allowedExtensions = ["png", "jpg", "jpeg"]; // Extensiones permitidas

    // Verifica si se seleccionó un archivo
    if (file) {
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
                    const width = img.width;
                    const height = img.height;

                    if (width >= 920 && height >= 520) {
                        props.form.img = file;
                    }else{
                        openModal(false);
                        event.target.value = '';
                    }
                }
            };
            reader.readAsDataURL(file); // Lector de archivos
            // Asigna el archivo seleccionado al formulario
            
            props.form.img = file; // Asigna el archivo seleccionado al formulario
        }
    }
}
</script>

<template>
    <div class="container px-5 py-8 mx-auto sm:px-20">
    <FormSection @submitted="$emit('submit')">
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
                <input type="file" id="img" @change="handleImageUpload" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"></input>
                <InputError :message="$page.props.errors.img" class="mt-2"/>
            </div>
            
        </template>
        
            <template #actions>
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
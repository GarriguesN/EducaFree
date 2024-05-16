<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';
    import Modal from '../Modal.vue';
    import {ref} from  "vue";

    //Definicion de los props
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

    // Función para abrir el modal
    const openModal = () => {
        showModal.value = true;
    };

    // Función para manejar la carga de archivos de pdfs
    const handleImageUpload = (event) => {
        const file = event.target.files[0]; // Accede al archivo seleccionado
        const allowedExtensions = ["pdf"]; // Extensiones permitidas

        // Verifica si se seleccionó un archivo
        if (file) {
            const extension = file.name.split('.').pop().toLowerCase(); // Obtiene la extensión del archivo
            // Verifica si la extensión es PDF
            if (!allowedExtensions.includes(extension)) {
                openModal()
                event.target.value = '';
            }else{
                props.form.file = file;
            }
        }
    }

    const emits = defineEmits(["submit"]);


const errorMessage = ref('');
const checkFields = () => {
    let fileEmpty = !props.form.file;

     if (fileEmpty) {
        errorMessage.value = 'Please upload a PDF';
    } else {
        emits('submit');
    }

    if (fileEmpty) {
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
            {{ updating ? 'Edit Contents': 'New Contents'}}
        </template>

        <template #description>
            {{ updating ? 'Edit': 'Add new content'}}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <input type="hidden" v-model="form.id">

                <InputLabel for="file" value="PDF" class="mt-3"/>
                <input type="file" id="file" @change="handleImageUpload" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"></input>
                <InputError :message="$page.props.errors.file" class="mt-2"/>
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
                <h3 class="mb-5 text-lg font-normal text-gray-500">Only PDF's!</h3>
                <button @click="showModal=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Ok</button>
        </div>
</Modal>

</template>
<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import DeleteButton from '../DeleteButton.vue';
    import TextInput from '../TextInput.vue';
    import Modal from '../Modal.vue';
    import {ref} from  "vue";

    // Definicion de props
  const props =  defineProps({
        form: { 
            type: Object,
            required: true
        },
    });

    // Definicion de emits
    defineEmits(["submit"]);

    // Variables reactivas
    const showModal =ref(false);
    const selectedId =ref(null);

    // Funcion para mostrar el modal
    const openModal = (id) => {
            showModal.value = true;
            selectedId.value = id;
    };

</script>

<template>
    <div class="container px-5 py-8 mx-auto">
    <FormSection @submitted="$emit('submit')">
        <template #title>
            Delete your account
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
             <p>I'm going to delete my own user account. By doing this, all my personal information, including my name, email, and any associated data, will be permanently removed from the system.<br><br> This action cannot be undone.</p>
            </div>
        </template>

        <template #actions>
            <Modal :show="showModal" @close="showModal = false" maxWidth="sm">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>

                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-200">Are you sure you want to delete your account?</h3> 
                <DeleteButton>
                    Yes, delete
                </DeleteButton>
                <button @click="showModal=false" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No, cancel</button>
            </div>
        </Modal>
        
            <a class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer" @click="openModal($page.props.auth.user.id)">
                Delete
            </a>
        </template>

    </FormSection>
</div>
</template>
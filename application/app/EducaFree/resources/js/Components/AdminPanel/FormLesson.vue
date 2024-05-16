<script setup>
    import { ref } from 'vue';
import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';

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

    // Definir un evento para emitir el formulario
    const emits = defineEmits(["submit"]);


const errorMessage = ref('');
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
            {{ updating ? 'Edit lesson': 'New lesson'}}
        </template>

        <template #description>
            {{ updating ? 'Edit the selected lesson': 'Add a new lesson to the course'}}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <input type="hidden" v-model="form.id">
                <InputLabel for="name" value="Name"/>
                <TextInput id="name" v-model="form.name" type="text" autocomplete="lesson-name" class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.name" class="mt-2"/>

                <InputLabel for="description" value="Description" class="mt-3"/>
                <textarea id="description" v-model="form.description" autocomplete="lesson-description" class="dark:bg-zinc-600 dark:border-gray-600 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" rows="4"></textarea>
                <InputError :message="$page.props.errors.description" class="mt-2"/>
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
</template>
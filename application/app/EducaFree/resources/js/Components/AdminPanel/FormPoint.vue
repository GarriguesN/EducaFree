<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';
    import TextEditor from '../TextEditor.vue'
    import { ref } from 'vue';


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

    const character = ref();

    const characterCount = (content) => {
        character.value = content
        console.log(character)
    }

    // Definir un evento para emitir el formulario
    const emits = defineEmits(["submit"]);

    const errorMessage = ref('');
const checkFields = () => {
    let nameEmpty = !props.form.name;
    let descriptionEmpty = !props.form.explanation;

    if (nameEmpty && (descriptionEmpty || character.value == 0)) {
        errorMessage.value = 'Please fill Name and Description fields';
    } else if (nameEmpty) {
        errorMessage.value = 'Please fill Name field';
    } else if (descriptionEmpty || character.value == 0) {
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
    <div class="container px-5 py-8 mx-auto sm:px-20 min-h-[15rem]">
        <FormSection @submitted="checkFields()">
            <template #title>
                {{ updating ? 'Edit point': 'New point'}}
            </template>

            <template #description>
                {{ updating ? 'Edit the selected point': 'Add a new point to the lesson'}}
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-6">
                    <input type="hidden" v-model="form.id">
                    <InputLabel for="name" value="Name"/>
                    <TextInput id="name" v-model="form.name" type="text" autocomplete="point-name" class="mt-1 block w-full"/>
                    <InputError :message="$page.props.errors.name" class="mt-2"/>

                    <InputLabel for="explanation" value="Explanation" class="mt-3"/>
                    <TextEditor v-model="form.explanation" @characterCount="characterCount"/>
                    <InputError :message="$page.props.errors.explanation" class="mt-2"/>
                </div>
            </template>

            <template #actions>
                <InputError :message="errorMessage" class="mr-2 mt-2"/>
                <PrimaryButton class="mt-2">
                    {{ updating ? 'Edit' : 'Add'}}
                </PrimaryButton>
            </template>
        </FormSection>
    </div>
</template>
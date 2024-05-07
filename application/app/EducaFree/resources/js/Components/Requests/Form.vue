<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';

    // Definicion de props
    defineProps({
        form: { 
            type: Object,
            required: true
        }
    });

    // Definicion de emits
    defineEmits(["submit"]);
</script>

<template>
    <div class="container px-5 py-8 mx-auto sm:px-20">
    <FormSection @submitted="$emit('submit')">
        <template #title>
            Send us a request
        </template>

        <template #description>
            If you see that you are missing something, or that we should add a course that you see necessary, or that you simply like, send it to us!
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="title" value="Title"/>
                <TextInput id="title" v-model="form.title" type="text" autocomplete="request-title" class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.title" class="mt-2"/>

                <InputLabel for="description" value="Description" class="mt-3"/>
                <textarea id="description" v-model="form.description" autocomplete="request-description" class="dark:bg-zinc-600 dark:border-gray-600 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" rows="4"></textarea>
                <InputError :message="$page.props.errors.description" class="mt-2"/>
            </div>
            
        </template>
        
            <template #actions>
                <PrimaryButton class="mt-2">
                    Send
                </PrimaryButton>
            </template>
            
        
    </FormSection>
</div>
</template>
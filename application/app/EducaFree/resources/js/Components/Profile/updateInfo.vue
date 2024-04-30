<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';

    // Definicion de props
  const props =  defineProps({
        form: { 
            type: Object,
            required: true
        },
        name: String,
        email: String
    });

    // Definicion de emits
    defineEmits(["submit"]);

    //Rellenar las variables del form con los props
    props.form.name = props.name;
    props.form.email = props.email;
</script>

<template>
            
    <div class="container px-5 py-8 mx-auto">
    <FormSection @submitted="$emit('submit')">
        <template #title>
            Update your user info
        </template>

        <template #form>
            <div class="col-span-6 md:col-span-6">
                <InputLabel for="name" value="Name" class="mt-3"/>
                <TextInput id="name" v-model="form.name" type="text" autocomplete="user-name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"/>
                <InputError :message="$page.props.errors.name" class="mt-2"/>

                <InputLabel for="email" value="Email" class="mt-3"/>
                <TextInput id="email" v-model="form.email" type="email" autocomplete="user-email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"/>
                <InputError :message="$page.props.errors.email" class="mt-2"/>
            </div>
        </template>
        
            <template #actions>
                <PrimaryButton class="mt-2">
                    Update
                </PrimaryButton>
            </template>
            
        
    </FormSection>
</div>
</template>
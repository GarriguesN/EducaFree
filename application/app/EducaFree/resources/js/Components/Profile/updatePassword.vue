<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';

    // Definicion de props
    const props = defineProps({
        form: { 
            type: Object,
            required: true
        },
        id: Number
    });

    // Definicion de emits
    defineEmits(["submit"]);
</script>

<template>
    <div class="container px-5 py-8 mx-auto">
    <FormSection @submitted="$emit('submit')">
        <template #title>
            Update your password
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="currentPassword" value="Current password"/>
                <TextInput id="currentPassword" v-model="form.currentPassword" type="password" autocomplete="user-currentPassword" class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.currentPassword" class="mt-2"/>

                <InputLabel for="newPassword" value="New password" class="mt-3"/>
                <TextInput id="newPassword" v-model="form.newPassword"  type="password" autocomplete="user-newPassword" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"></TextInput>
                <InputError :message="$page.props.errors.newPassword" class="mt-2"/>

                <InputLabel for="repeatPassword" value="Repeat new password" class="mt-3"/>
                <TextInput id="repeatPassword" v-model="form.repeatPassword" type="password" autocomplete="user-repeatPassword" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"></TextInput>
                <InputError :message="$page.props.errors.repeatPassword" class="mt-2"/>
            </div>
        </template>
        
            <template #actions>
                <PrimaryButton class="mt-2">
                    Update Password
                </PrimaryButton>
            </template>
            
        
    </FormSection>
</div>
</template>

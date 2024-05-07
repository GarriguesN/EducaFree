<script setup>
    import InputError from '../InputError.vue';
    import PrimaryButton from '../PrimaryButton.vue';

    // Definición de props
    defineProps({
        form: { 
            type: Object,
            required: true
        },
        reply:{
            type: Boolean,
            default: false
        },
        edit:{
            type: Boolean,
            default: false
        }
    });

    // Definición de emits
    defineEmits(["submit"]);
</script>

<template>
<div class="container " :class="!reply && !edit ? 'px-5 py-8 mx-auto sm:px-20' : 'px-1 py-1 mx-auto sm:px-20'">
    <p v-if="!reply && !edit" class="text-left">Post a comment!</p>
    <form @submit.prevent="$emit('submit')">
        <div class="col-span-6 sm:col-span-6 flex items-center justify-center">
            <input type="hidden" v-model="form.id">
            <textarea id="comment" name="comment" v-model="form.comment" autocomplete="comment" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-[80%] dark:bg-zinc-600 dark:border-gray-600" rows="1"></textarea>
            <InputError :message="$page.props.errors.comment" class="m-2"/>

            <PrimaryButton class="m-5" :type="'button'" @click.prevent="$emit('submit')">
                {{!edit ? 'comment' : 'edit'}}
            </PrimaryButton>
        </div>    
    </form>  
</div>
</template>
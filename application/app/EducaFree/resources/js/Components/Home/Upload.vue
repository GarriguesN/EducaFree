<script setup>
import CourseTab from '../AdminPanel/CourseTab.vue'
    const props = defineProps({
        adminpanel: {
            type: Boolean
        }
    })
</script>

<template>
    <section :class="adminpanel ? 'h-full' : 'pt-10'">
        <div v-if="$page.props.pending" class="text-center text-gray-400 dark:text-gray-200 border-b mb-10 dark:bg-zinc-600 dark:border-gray-600" :class="adminpanel ? 'mt-2 p-2' : ' mt-[5rem] p-4'">
            This course is pending. Please wait. You can still update it, but it's possible we take longer to validate the course. Thank you for your contribution to our community.<br>
            You can delete this course clicking <a :href="route('pendingcourse.delete')" class="text-red-500 font-bold hover:underline cursor-pointer">here</a>  
        </div>
        <div v-else class="pt-20 h-1">

        </div>
        <div v-if="$page.props.count > 0" class="text-center text-gray-400 dark:text-gray-200 dark:bg-zinc-600 dark:border-gray-600">
            Thank you for contributing to our community! So far, you have uploaded {{ $page.props.count }} courses.
            Keep up the good work and continue to help grow the platform!
        </div>
        <CourseTab :course="$page.props.course" :lessons="$page.props.lessons" :points="$page.props.points"></CourseTab>
    </section>
</template>

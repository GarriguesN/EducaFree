<script setup>
import Card from '../Courses/Card.vue'
// Definicion de props
defineProps({
    courses: {
        type: Number,
        required: true
    },
    randomCourses:{
        type: Array,
        required: true
    },
    oneRandom:{
        type: Array,
        required: true
    }
});

</script>

<template>
    <section class="bg-white h-72 flex justify-end content-center flex-col shadow-lg
                    dark:bg-zinc-700 dark:text-white
    ">
        <p class="text-center text-5xl font-[1000] md:text-7xl mb-5">Welcome to EducaFree</p>
        <div class="bg-blue-700 flex items-center justify-center shadow-lg">
            <h3 class="text-white">Learn free from anonymous people!</h3>
        </div>
    </section>

    <section id="courses" class="p-4 dark:bg-zinc-700 dark:text-white">
            <div class="container px-5 py-8 mx-auto sm:px-20">
                    <div v-if="$page.props.courses > 0">
                        <h3 class="mb-4 text-3xl font-bold md:text-3xl lg:text-4xl text-center">WE HAVE MORE THAN <span class="text-blue-600 dark:text-blue-500 font-extrabold">+{{ $page.props.courses }}</span> COURSES</h3>
                        <p class="text-lg font-normal lg:text-xl">At our platform, we believe in the power of learning freely from anonymous individuals. Our slogan, <span class="underline decoration-blue-600">"Learn free from anonymous people"</span>, embodies our commitment to creating a unique and inclusive learning environment where anonymity is celebrated as a catalyst for uninhibited exploration and discovery.</p>
                        <p class="text-lg font-normal lg:text-xl">Join us today and experience the freedom of learning without constraints. Embrace anonymity, embrace curiosity, and embrace the endless possibilities of knowledge. Discover new passions, make meaningful connections, and find courses that inspire you – just <a class="font-medium text-blue-600 dark:text-blue-500 underline hover:no-underline cursor-pointer" data-popover-target="popover-image">like this one!</a></p>

                        <div id="popover-image" role="tooltip" class="absolute z-10 invisible inline-block text-sm transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-auto h-auto">
                            <Card  :course="$page.props.oneRandom[0]" :where="'home'"/>
                        </div>
                    </div>
                    <div v-else>
                        <p>No courses available</p>
                    </div>
            </div>
        </section>

        <section id="randomCourses" class="dark:bg-zinc-700 dark:text-white">
            <div class="container px-5 py-8 mx-auto sm:px-20 border-t dark:border-gray-600">
                <h1 class="text-center mb-4 text-2xl font-bold pb-2">COURSES OF THE DAY</h1>
                <div v-if="$page.props.randomCourses.length > 0" class="grid grid-cols-1 min-[770px]:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 xl:m-auto gap-x-[7.1rem] gap-y-10 justify-items-center items-center">  
                    <Card v-for="course in $page.props.randomCourses" :course="course" :where="'home'" />
                </div>
                <div v-else>
                    <p>No courses available</p>
                </div>
            </div>
        </section>

</template>
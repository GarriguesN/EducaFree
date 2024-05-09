<script setup>
import { ref, onMounted } from 'vue';
import { fetchMostLikedInfoData } from './services/fetchMostLikedInfoData';

const courses = ref([]); 
const totalLikes = ref(0);
const filter = ref('Show 6 most liked');
const message = ref('6 courses most liked');
const percentageOfUsersWhoLiked = ref(0);
const totalUsers = ref(0);

// Function to fetch course data for a specific time range
const updateMostLikedData = async (timeRange) => {
    try {
        const data = await fetchMostLikedInfoData(timeRange);

        // Update the state with the data
        courses.value = data.courses
        totalLikes.value = data.totalLikes;
        totalUsers.value = data.totalUsers

        if (filter.value === 'Total likes') {
            percentageOfUsersWhoLiked.value = (totalUsers.value > 0) 
                ? (totalLikes.value / totalUsers.value) * 100 
                : 0;
        }
        console.log(totalLikes.value, totalUsers.value, (totalLikes.value / totalUsers.value))
    } catch (error) {
        console.error('Error updating course data:', error);
    }
};

// Fetch course data for the default time range on component mount
onMounted(async () => {
    updateMostLikedData('sixLiked');
});

// Event handlers for dropdown items
const showSix = () => {
    updateMostLikedData('sixLiked');
    filter.value = 'Show 6 most liked';
    message.value = '6 courses most liked';
};

const showThree = () => {
    updateMostLikedData('threeLiked');
    filter.value = 'Show 3 most liked';
    message.value = '3 courses most liked';
};

const showOne = () => {
    updateMostLikedData('oneLiked');
    filter.value = 'Show the most liked';
    message.value = 'Most liked course';
};

const selectAll = () => {
    filter.value = 'Total likes';
    message.value = 'Total likes';

    percentageOfUsersWhoLiked.value = (totalUsers.value > 0) 
        ? (totalLikes.value / totalUsers.value) * 100 
        : 0;
};

</script>

<template>
<div class="w-full border-1 bg-white rounded-sm shadow p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none flex flex-row text-xl font-bold items-center text-gray-900 pb-2">
                <!-- Display courses and their likes -->
                <div v-if="filter === 'Total likes'">
                    <div class="text-3xl">{{ totalLikes }}</div>
                    <!-- Display the percentage of users who liked -->
                    <div class="text-base font-normal text-gray-500">
                        Total {{ percentageOfUsersWhoLiked.toFixed(2) }}% of users has liked a course
                    </div>
                </div>
                <ul class="grid grid-cols-2 gap-3" v-if="filter !== 'Total likes'">
                    <li v-for="course in courses" :key="course.course_id" class="flex flex-row">
                        <span>{{ course.course_name }}</span> 
                        <span class="ml-3 text-blue-600">{{ course.like_count }} likes</span>
                        <span class="ml-2 text-gray-500">({{ course.percentage_of_total_users.toFixed(2) }}%)</span>
                    </li>
                </ul>
            </h5>
            <p class="text-base font-normal text-gray-500">{{ message }}</p>
        </div>
        <!-- Display the total likes and any other additional information -->
        <div>
            <p class="text-base font-normal text-gray-500">Total Likes: {{ totalLikes }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
        <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
            id="dropdownDefaultButtonMostLiked"
            data-dropdown-toggle="lastDaysdropdownMostLiked"
            data-dropdown-placement="bottom"
            class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
            type="button">
            {{ filter }}
            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdownMostLiked" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
          <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButtonMostLiked">
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showSix">Show 6 most liked</a>
            </li>
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showThree">Show 3 most liked</a>
            </li>
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showOne">Show the most liked</a>
            </li>
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectAll">Total likes</a>
            </li>
          </ul>
        </div>
        </div>
    </div>
</div>
</template>



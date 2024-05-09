<script setup>
import { ref, onMounted } from 'vue';
import { fetchCompetedInfoData } from './services/fetchCompetedInfoData';

// State variables
const completedCourses = ref([]);
const overallCompletionRate = ref(0);
const totalUsers = ref(0); // The total number of users
const filter = ref('Show all');
const message = ref('Total completed');
const isLoading = ref(false);

// Function to fetch course completion data for a specific time range
const updateCompletionData = async (timeRange) => {
    try {
        isLoading.value = true;
        const data = await fetchCompetedInfoData(timeRange);

        // Update the state with the data
        completedCourses.value = data.courses;
        overallCompletionRate.value = data.overallCompletionRate;
        totalUsers.value = data.totalUsers;
        isLoading.value = false;
    } catch (error) {
        console.error('Error updating completion data:', error);
    }
};

// Fetch completion data for the default time range on component mount
onMounted(async () => {
    updateCompletionData('all');
});

// Event handlers for dropdown items
const showAll = () => {
    updateCompletionData('all');
    filter.value = 'Show all';
    message.value = 'Total completed';
};

const selectToday = () => {
    updateCompletionData('today');
    filter.value = 'Today';
    message.value = 'Courses completed today';
};

const selectLast7Days = () => {
    updateCompletionData('last7days');
    filter.value = 'Last 7 days';
    message.value = 'Courses completed this week';
};

const selectLast30Days = () => {
    updateCompletionData('last30days');
    filter.value = 'Last 30 days';
    message.value = 'Courses completed this month';
};

const selectLast90Days = () => {
    updateCompletionData('last90days');
    filter.value = 'Last 90 days';
    message.value = 'Courses completed in this two months';
};
</script>

<template>
    <div class="w-full border-1 bg-white rounded-sm shadow p-4 md:p-6">
        <div class="flex justify-between">
            <div>
                
                <h5 class="leading-none text-3xl flex font-bold items-center text-gray-900 pb-2">
                    <!-- Display overall completion rate -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                    <div v-if="isLoading" role="status" class="space-y-2.5 animate-pulse max-w-lg">
                        <div  class="h-5 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></div>
                    </div>
                    <div v-else>
                        {{ overallCompletionRate }}%
                    </div>
                </h5>
                <p class="text-base font-normal text-gray-500">{{ message }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
            <div class="flex justify-between items-center pt-5">
            <!-- Button -->
            <button
                id="dropdownDefaultButtonCompleted"
                data-dropdown-toggle="lastDaysdropdownCompleted"
                data-dropdown-placement="bottom"
                class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
                type="button">
                {{ filter }}
                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="lastDaysdropdownCompleted" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButtonCompleted">
                    <li>
                        <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showAll">Show all</a>
                    </li>
                    <li>
                        <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectToday">Today</a>
                    </li>
                    <li>
                        <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast7Days">Last 7 days</a>
                    </li>
                    <li>
                        <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast30Days">Last 30 days</a>
                    </li>
                    <li>
                        <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast90Days">Last 90 days</a>
                    </li>
                </ul>
            </div>
            </div>
            <!-- Display completion data per course -->
            <div>
                <ul>
                    <li v-for="course in completedCourses" :key="course.course_id">
                        {{ course.course_name }} - {{ course.completion_rate }}% completion
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </template>
    



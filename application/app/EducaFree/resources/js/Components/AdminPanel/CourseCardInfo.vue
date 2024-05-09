<script setup>
import { ref, onMounted } from 'vue';
import { fetchCourseInfoData } from './services/fetchCourseInfoData';

const coursesCount = ref(0);
const courseChange = ref(0);
const coursePercentageChange = ref(0);
const filter = ref('Show all');
const message = ref('All courses');

// Function to fetch course data for a specific time range
const updateCourseData = async (timeRange) => {
    try {
        const data = await fetchCourseInfoData(timeRange);

        // Update the state with the data
        coursesCount.value = data.coursesCountInRange;
        courseChange.value = data.change;
        coursePercentageChange.value = data.percentageChange;
    } catch (error) {
        console.error('Error updating course data:', error);
    }
};

// Fetch course data for the default time range on component mount
onMounted(async () => {
    updateCourseData('all');
});

// Event handlers for dropdown items
const showAll = () => {
    updateCourseData('all');
    filter.value = 'Show all';
    message.value = 'All courses';
};

const selectToday = () => {
    updateCourseData('today');
    filter.value = 'Today';
    message.value = 'Courses today';
};

const selectLast7Days = () => {
    updateCourseData('last7days');
    filter.value = 'Last 7 days';
    message.value = 'Courses this week';
};

const selectLast30Days = () => {
    updateCourseData('last30days');
    filter.value = 'Last 30 days';
    message.value = 'Courses this month';
};

const selectLast90Days = () => {
    updateCourseData('last90days');
    filter.value = 'Last 90 days';
    message.value = 'Courses this two months';
};
</script>

<template>
<div class="w-full border-1 bg-white rounded-sm shadow p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none text-3xl flex font-bold items-center text-gray-900 pb-2">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                {{ coursesCount }}
            </h5>
            <p class="text-base font-normal text-gray-500">{{ message }}</p>
        </div>
        <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-center" :class="{ 'text-green-500': coursePercentageChange > 0, 'text-red-500': coursePercentageChange < 0, 'text-black': coursePercentageChange === 0 }">
            {{ coursePercentageChange }}%
            <svg v-if="coursePercentageChange > 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg>
            <svg v-if="coursePercentageChange < 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14" transform="rotate(180)">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg>
            <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-900">
                <span :class="{ 'text-green-500': courseChange > 0, 'text-red-500': courseChange < 0 }">
                    {{ courseChange }} courses {{ courseChange > 0 ? '+' : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
        <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
            id="dropdownDefaultButtonCourse"
            data-dropdown-toggle="lastDaysdropdownCourse"
            data-dropdown-placement="bottom"
            class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
            type="button">
            {{ filter }}
            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdownCourse" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
          <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButtonCourse">
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showAll">Show all</a>
            </li>
            <li>
              <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectToday">Today</a>
            </li>
            <li>
              <a  class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast7Days">Last 7 days</a>
            </li>
            <li>
              <a  class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast30Days">Last 30 days</a>
            </li>
            <li>
              <a  class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="selectLast90Days">Last 90 days</a>
            </li>
          </ul>
        </div>
        <a :href="route('dashboard.courses')" class="ml-4 text-xs text-gray-400 flex items-center hover:text-blue-600"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a>
        </div>
        
    </div>
</div>
</template>



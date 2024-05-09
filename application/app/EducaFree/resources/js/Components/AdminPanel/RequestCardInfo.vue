<script setup>
import { ref, onMounted } from 'vue';
import { fetchRequestInfoData } from './services/fetchRequestInfoData';

const completedRequestsCount = ref(0);
const notcompletedRequestsCount = ref(0);
const requestsChange = ref(0);
const requestPercentageChange = ref(0);

const filter = ref('Show all');
const message = ref('All requests (completed/not)');

// Function to fetch course data based on completion status
const updateRequestData = async (timeRange) => {
    try {
        const data = await fetchRequestInfoData(timeRange);

        // Update the state with the data
        completedRequestsCount.value = data.completedRequestsCount;
        notcompletedRequestsCount.value = data.notCompletedRequestsCount;

        requestsChange.value = data.difference;
        requestPercentageChange.value = data.percentageChange;
    } catch (error) {
        console.error('Error updating course data:', error);
    }
};

// Fetch course data for the default status (show all) on component mount
onMounted(async () => {
    updateRequestData('all');
});

// Event handlers for dropdown items
const showAll = () => {
    updateRequestData('all');
    filter.value = 'Show all';
    message.value = 'All requests (completed/not)';
};

const showCompleted = () => {
    updateRequestData('completed');
    filter.value = 'Completed';
    message.value = 'Completed requests';
};

const showNotCompleted = () => {
    updateRequestData('notCompleted');
    filter.value = 'Not completed';
    message.value = 'Not completed requests';
};

</script>

<template>
<div class="w-full border-1 bg-white rounded-sm shadow p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none text-3xl flex font-bold items-center text-gray-900 pb-2">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                {{ filter.includes('Completed') ? completedRequestsCount : filter.includes('Show all') ? completedRequestsCount +'/'+ notcompletedRequestsCount : notcompletedRequestsCount }}
            </h5>
            <p class="text-base font-normal text-gray-500">{{ message }}</p>
        </div>
        
    </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
        <div class="flex justify-between items-center pt-5">
            <!-- Button -->
            <button
                id="dropdownDefaultButtonRequest"
                data-dropdown-toggle="lastDaysdropdownRequest"
                data-dropdown-placement="bottom"
                class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
                type="button">
                {{ filter }}
                <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="lastDaysdropdownRequest" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButtonRequest">
                <li>
                  <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showAll">Show all</a>
                </li>
                <li>
                  <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showCompleted">Completed</a>
                </li>
                <li>
                  <a class="cursor-pointer block px-4 py-2 hover:bg-gray-100" @click="showNotCompleted">Not completed</a>
                </li>
              </ul>
            </div>
            <a :href="route('dashboard.requests')" class="ml-4 text-xs text-gray-400 flex items-center hover:text-blue-600"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a>
        </div>
    </div>
</div>
</template>



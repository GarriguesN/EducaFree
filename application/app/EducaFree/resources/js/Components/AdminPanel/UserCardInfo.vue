<script setup>
import { onMounted, ref } from 'vue';
import { fetchUserInfoData } from './services/fetchUserInfoData';

const usersCount = ref();
const percentageChange = ref(0);
const change = ref(null);
const filter = ref('Show all');
const message = ref('All users')

// Function to fetch user data for a specific time range
const updateUserData = async (timeRange) => {
    try {
        const data = await fetchUserInfoData(timeRange);
        
        // Log the fetched data for debugging
        console.log('Fetched data:', data);
        
        // Update the state with the data
        usersCount.value = data.usersCountInRange;
        percentageChange.value = data.percentageChange;
        change.value = data.change;
    } catch (error) {
        console.error('Error updating user data:', error);
    }
};

onMounted(async() => {
    updateUserData('all')
})

// Event handlers for each dropdown item
const showAll = () => {
    updateUserData('all');
    filter.value = 'Show all'
    // Update the message to reflect the selected time range
    message.value = 'All users'
};

const selectToday = () => {
    updateUserData('today');
    filter.value = 'Today'
    // Update the message to reflect the selected time range
    message.value = 'Users today'
};

const selectLast7Days = () => {
    updateUserData('last7days');
    filter.value = 'Last 7 days'
    // Update the message to reflect the selected time range
    message.value = 'Users this week'
};

const selectLast30Days = () => {
    updateUserData('last30days');
    filter.value = 'Last 30 days'
    // Update the message to reflect the selected time range
    message.value = 'Users this month'
};

const selectLast90Days = () => {
    updateUserData('last90days');
    filter.value = 'Last 90 days'
    // Update the message to reflect the selected time range
    message.value = 'Users this two month'
};

</script>

<template>
<div class="max-w-lg  w-full border-1 bg-white rounded-sm shadow p-4 md:p-6 bg">
    <div class="flex justify-between">
        <div>
        <h5 class="leading-none text-3xl flex font-bold items-center text-gray-900 pb-2">
            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            {{usersCount}}
        </h5>
        <p class="text-base font-normal text-gray-500">{{message}}</p>
        </div>

        <div class="flex items-center px-2.5 py-0.5 text-base font-semibold  text-center" :class="percentageChange === 0 ? 'text-black' : (percentageChange < 0 ? 'text-red-500' : 'text-green-500')">
            {{percentageChange}} %
        <svg v-if="percentageChange > 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
        <svg v-if="percentageChange < 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14" transform="rotate(180)">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
        <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-900">
            <span :class="{ 'text-green-500': change > 0, 'text-red-500': change < 0 }">
                {{ change }} users {{ change < 0 ? '' : '+' }}
            </span>
        </div>
        </div>

    </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
        <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
            id="dropdownDefaultButton"
            data-dropdown-toggle="lastDaysdropdown"
            data-dropdown-placement="bottom"
            class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
            type="button">
            {{ filter }}
            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
          <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
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
        <a :href="route('dashboard.users')" class="ml-4 text-xs text-gray-400 flex items-center hover:text-blue-600"> Go to table <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></a>
        </div>
    </div>
</div>
</template>



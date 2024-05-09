<script setup>
import { ref, onMounted } from 'vue';
import { fetchLtiConsumerInfoData } from './services/fetchLtiConsumerInfoData';

const ltiPlatformsCount = ref(0);
const ltiPlatformChange = ref(0); 
const ltiPlatformPercentageChange = ref(0); 
const filter = ref('Show all');
const message = ref('All platforms using LTI Tool'); 

// Function to fetch LTI platform data for a specific time range
const updateLtiConsumer = async (timeRange) => {
    try {
        const data = await fetchLtiConsumerInfoData(timeRange);

        // Update the state with the data
        ltiPlatformsCount.value = data.count;
        ltiPlatformChange.value = data.change;
        ltiPlatformPercentageChange.value = data.percentageChange;
        console.log(data.percentageChange)
    } catch (error) {
        console.error('Error updating LTI platform data:', error);
    }
};

onMounted(async () => {
    updateLtiConsumer('all');
    console.log(ltiPlatformPercentageChange.value)
});

const showAll = () => {
    updateLtiConsumer('all');
    filter.value = 'Show all';
    message.value = 'All platforms using LTI Tool';
};

const selectToday = () => {
    updateLtiConsumer('today');
    filter.value = 'Today';
    message.value = 'Platforms using LTI Tool today';
};

const selectLast7Days = () => {
    updateLtiConsumer('last7days');
    filter.value = 'Last 7 days';
    message.value = 'Platforms using LTI Tool this week';
};

const selectLast30Days = () => {
    updateLtiConsumer('last30days');
    filter.value = 'Last 30 days';
    message.value = 'Platforms using LTI Tool this month';
};

const selectLast90Days = () => {
    updateLtiConsumer('last90days');
    filter.value = 'Last 90 days';
    message.value = 'Platforms using LTI Tool in the last 90 days';
};

</script>

<template>
<div class="w-full border-1 bg-white rounded-sm shadow p-4 md:p-6">
    <div class="flex justify-between">
        <div>
            <h5 class="leading-none text-3xl flex font-bold items-center text-gray-900 pb-2">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="square" stroke-linejoin="bevel"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                {{ ltiPlatformsCount }}
            </h5>
            <p class="text-base font-normal text-gray-500">{{ message }}</p>
        </div>
        <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-center" :class="{ 'text-green-500': ltiPlatformPercentageChange > 0, 'text-red-500': ltiPlatformPercentageChange < 0, 'text-black': ltiPlatformPercentageChange === 0 }">
            {{ ltiPlatformPercentageChange }}%
            <svg v-if="ltiPlatformPercentageChange > 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg>
            <svg v-if="ltiPlatformPercentageChange < 0" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14" transform="rotate(180)">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg>
            <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-gray-900">
                <span :class="{ 'text-green-500': ltiPlatformChange > 0, 'text-red-500': ltiPlatformChange < 0 }">
                    {{ ltiPlatformChange }} courses {{ ltiPlatformChange > 0 ? '+' : '' }}
                </span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
        <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
            id="dropdownDefaultButtonAgent"
            data-dropdown-toggle="lastDaysdropdownAgent"
            data-dropdown-placement="bottom"
            class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
            type="button">
            {{ filter }}
            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdownAgent" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
          <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButtonAgent">
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
        </div>
    </div>
</div>
</template>



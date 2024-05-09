import axios from 'axios';

const baseURL = '/api/useragent/count';

const fetchUserAgentInfoData = async (timeRange) => {
    try {

        const response = await axios.get(baseURL, {
            params: {
                timeRange: timeRange,
            },
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching User Agent info data:', error);
        throw error;
    }
};


export { fetchUserAgentInfoData };
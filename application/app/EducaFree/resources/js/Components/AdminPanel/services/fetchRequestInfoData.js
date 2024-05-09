import axios from 'axios';

const baseURL = '/api/requests/count';

const fetchRequestInfoData = async (timeRange) => {
    try {

        const response = await axios.get(baseURL, {
            params: {
                timeRange: timeRange,
            },
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching requests info data:', error);
        throw error;
    }
};


export { fetchRequestInfoData };
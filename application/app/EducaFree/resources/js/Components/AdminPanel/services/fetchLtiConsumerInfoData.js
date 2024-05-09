import axios from 'axios';

const baseURL = '/api/lticonsumer/count';

const fetchLtiConsumerInfoData = async (timeRange) => {
    try {

        const response = await axios.get(baseURL, {
            params: {
                timeRange: timeRange,
            },
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching Lti consumers info data:', error);
        throw error;
    }
};


export { fetchLtiConsumerInfoData };
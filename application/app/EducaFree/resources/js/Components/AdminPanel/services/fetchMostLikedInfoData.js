import axios from 'axios';

const baseURL = '/api/mostliked/count';

const fetchMostLikedInfoData = async (timeRange) => {
    try {

        const response = await axios.get(baseURL, {
            params: {
                timeRange: timeRange,
            },
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching courses info data:', error);
        throw error;
    }
};


export { fetchMostLikedInfoData };
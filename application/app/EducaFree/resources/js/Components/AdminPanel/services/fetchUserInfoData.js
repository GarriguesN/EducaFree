import axios from 'axios';

const baseURL = '/api/users/count';

const fetchUserInfoData = async (timeRange) => {
    try {

        const response = await axios.get(baseURL, {
            params: {
                timeRange: timeRange,
            },
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching user info data:', error);
        throw error;
    }
};


export { fetchUserInfoData };
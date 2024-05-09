import axios from 'axios';

const baseURL = '/api/ai/request';

const fetchChatAiData = async (prompt) => {
    try {

        const response = await axios.post(baseURL, {
            prompt: prompt,
        });


        return response.data;
    } catch (error) {

        console.error('Error fetching AI data:', error);
        throw error;
    }
};


export { fetchChatAiData };
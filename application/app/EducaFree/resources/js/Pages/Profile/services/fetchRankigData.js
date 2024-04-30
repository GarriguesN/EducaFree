import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/ranking';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Función para obtener los datos del ranking de todos los usuarios
const fetchRankingData = async () => {

    try {
        const response = await axiosInstance.get(`/data/`);

        // Devolver los datos de la información del ranking del usuario
        return response.data;
    } catch (error) {
        console.error('Error fetching course info data:', error);
        throw error;
    }
};

export { fetchRankingData };
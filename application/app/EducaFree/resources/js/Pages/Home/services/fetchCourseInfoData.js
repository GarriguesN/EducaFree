import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/coursesInfo';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Función para obtener la información del curso del usuario
const fetchCourseInfoData = async (id) => {

    try {
        // Realizar la solicitud HTTP para obtener la información del curso del usuario
        const response = await axiosInstance.get(`/data/${id}`);

        // Devolver los datos de la información del curso del usuario
        return response.data;
    } catch (error) {
        console.error('Error fetching course info data:', error);
        throw error;
    }
};

export { fetchCourseInfoData };
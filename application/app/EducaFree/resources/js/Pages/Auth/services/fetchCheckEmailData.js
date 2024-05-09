import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/checkemail';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Función para obtener los datos del ranking de todos los usuarios
const fetchCheckEmailData = async (email) => {

    try {
        const response = await axiosInstance.get('/data', {
            params: {
              email: email,
            }
          });

        // Devolver los datos de la información del ranking del usuario
        return response.data;
    } catch (error) {
        console.error('Error checking email info data:', error);
        throw error;
    }
};

export { fetchCheckEmailData };
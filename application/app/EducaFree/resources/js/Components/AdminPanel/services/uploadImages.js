import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener datos de cursos
const uploadImages = async (image) => {
  try {
    const response = await axiosInstance.post('/upload/image', image);
    
    return response.data.url;
  } catch (error) {
    console.error('Error fetching course data:', error);
    throw error;
  }
};
// Exportar la función fetchCourseData
export { uploadImages };

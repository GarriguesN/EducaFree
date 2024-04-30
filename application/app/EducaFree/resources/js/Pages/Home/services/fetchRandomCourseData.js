import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/coursesRandoms';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener los datos de cursos randoms
const fetchRandomCourseData = async () => {
  try {
    const response = await axiosInstance.get('/data');
    
    return response.data;
  } catch (error) {
    console.error('Error fetching course data:', error);
    throw error;
  }
};
// Exportar la función fetchRandomCourseData
export { fetchRandomCourseData };

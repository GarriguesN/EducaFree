import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/courses';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener datos de cursos
const fetchCourseData = async (searchTerm = '') => {
  try {
    const response = await axiosInstance.get('/data', {
      params: {
        searchTerm: searchTerm
      }
    });
    
    return response.data.courses;
  } catch (error) {
    console.error('Error fetching course data:', error);
    throw error;
  }
};
// Export the fetchCourseData function
export { fetchCourseData };

import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/pendingcourses/dashboard/';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener datos de cursos pendientes
const fetchPendingCourseData = async (searchTerm = '', collaboratorId) => {
  try {
    const response = await axiosInstance.get('/data', {
      params: {
        searchTerm: searchTerm,
        collaboratorId: collaboratorId
      }
    });
    
    return response.data.courses;
  } catch (error) {
    console.error('Error fetching course data:', error);
    throw error;
  }
};
// Exportar la función fetchPendingCourseData
export { fetchPendingCourseData };

import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/reports';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener datos de reportes
const fetchReportsData = async (searchTerm = '') => {
  try {
    const response = await axiosInstance.get('/data', {
      params: {
        searchTerm: searchTerm
      }
    });
    
    return response.data.reports;
  } catch (error) {
    console.error('Error fetching course data:', error);
    throw error;
  }
};
// Exportar la función fetchReportsData
export { fetchReportsData };

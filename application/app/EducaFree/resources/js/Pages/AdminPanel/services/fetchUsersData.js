import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/users';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Definir una función para obtener datos de usuarios
const fetchUserData = async (searchTerm = '') => {
  try {
    const response = await axiosInstance.get('/data', {
      params: {
        searchTerm: searchTerm
      }
    });
    
    return response.data.users;
  } catch (error) {
    console.error('Error fetching user data:', error);
    throw error;
  }
};
// Exportar la función fetchUserData
export { fetchUserData };

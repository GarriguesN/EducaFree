import axios from 'axios';

// Definir la URL base para la API
const baseURL = '/api/comments';

// Crear una nueva instancia de Axios con la URL
const axiosInstance = axios.create({
  baseURL,
});

// Función para obtener los comentarios del curso con el ID especificado
const fetchCourseCommentsData = async (id, page, perPage = 5) => {
    try {
      const response = await axiosInstance.get(`/data/${id}?page=${page}`, {
        params: {
          page,
          perPage,
        },
      });
  
      return response.data.comments;
    } catch (error) {
      console.error('Error fetching course comments data:', error);
      throw error;
    }
  };
  
  export { fetchCourseCommentsData };
import axios from 'axios';
import { useRouter } from 'vue-router';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true,
});

// Interceptor para redirecionar quando receber 401 (não autenticado)
instance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Redireciona para login em caso de 401
      const router = useRouter();
      router.push({ name: 'login' }).catch(() => {});
    }
    return Promise.reject(error);
  }
);

export default instance;
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from '@/services/axios';

interface User {
  id: number;
  nome: string;
  usuario: string;
  email: string;
  telefone?: string;
  ativo: boolean;
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null);
  const isAuthenticated = computed(() => user.value !== null);
  const isLoading = ref(false);

  /**
   * Check if user is authenticated by calling /me
   */
  const checkAuth = async (): Promise<boolean> => {
    isLoading.value = true;
    try {
      const response = await axios.get<User>('/me');
      user.value = response.data;
      return true;
    } catch {
      user.value = null;
      return false;
    } finally {
      isLoading.value = false;
    }
  };

  /**
   * Perform logout
   */
  const logout = async (): Promise<void> => {
    try {
      await axios.post('/logout');
    } finally {
      user.value = null;
    }
  };

  /**
   * Set user after successful login
   */
  const setUser = (userData: User): void => {
    user.value = userData;
  };

  /**
   * Clear user
   */
  const clearUser = (): void => {
    user.value = null;
  };

  return {
    user,
    isAuthenticated,
    isLoading,
    checkAuth,
    logout,
    setUser,
    clearUser,
  };
});

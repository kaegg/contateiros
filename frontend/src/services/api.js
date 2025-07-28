// Configuração da API
const API_BASE_URL = 'http://localhost:8000/api';

// Função para fazer requisições HTTP
export async function apiRequest(endpoint, options = {}) {
  const url = `${API_BASE_URL}${endpoint}`;
  
  const defaultOptions = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
  };

  const config = {
    ...defaultOptions,
    ...options,
    headers: {
      ...defaultOptions.headers,
      ...options.headers,
    },
  };

  try {
    const response = await fetch(url, config);
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    return await response.json();
  } catch (error) {
    console.error('API Request Error:', error);
    throw error;
  }
}

// Serviços para Local
export const localService = {
  // Buscar todos os locais
  async getAll() {
    return apiRequest('/local');
  },

  // Buscar local específico
  async getById(id) {
    return apiRequest(`/local/${id}`);
  },

  // Criar novo local
  async create(localData) {
    return apiRequest('/local', {
      method: 'POST',
      body: JSON.stringify(localData),
    });
  },

  // Atualizar local
  async update(id, localData) {
    return apiRequest(`/local/${id}`, {
      method: 'PUT',
      body: JSON.stringify(localData),
    });
  },

  // Desativar local
  async delete(id) {
    return apiRequest(`/local/${id}`, {
      method: 'DELETE',
    });
  },

  // Buscar imagens de um local
  async getImages(localId) {
    return apiRequest(`/local/${localId}/imagens`);
  },

  // Buscar atividades de um local
  async getActivities(localId) {
    return apiRequest(`/local/${localId}/atividades`);
  },

  // Buscar instalações de um local
  async getFacilities(localId) {
    return apiRequest(`/local/${localId}/instalacoes`);
  },

  // Buscar avaliações de um local
  async getRatings(localId) {
    return apiRequest(`/local/${localId}/avaliacoes`);
  },
};

// Serviços para Atividades
export const activityService = {
  async getAll() {
    return apiRequest('/atividade');
  },
};

// Serviços para Instalações
export const facilityService = {
  async getAll() {
    return apiRequest('/instalacao');
  },
};

// Serviços para Usuários
export const userService = {
  async getAll() {
    return apiRequest('/usuario');
  },
};

// Função para calcular rating médio
export function calculateAverageRating(ratings) {
  if (!ratings || ratings.length === 0) return 0;
  
  const sum = ratings.reduce((total, rating) => total + rating.avaliacao, 0);
  return Math.round(sum / ratings.length);
}

// Função para mapear atividades do backend para o frontend
export function mapActivities(backendActivities) {
  const activityIcons = {
    'Jornada': 'pi pi-users',
    'Acampamento': 'pi pi-home',
    'Day Use': 'pi pi-sun',
    'Futebol': 'pi pi-compass',
    // Adicione mais mapeamentos conforme necessário
  };

  return backendActivities.map(activity => ({
    name: activity.nome,
    icon: activityIcons[activity.nome] || 'pi pi-star',
  }));
}

// Função para mapear instalações do backend para o frontend
export function mapFacilities(backendFacilities) {
  return backendFacilities.map(facility => facility.nome);
} 
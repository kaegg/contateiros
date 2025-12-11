// Configuração da API
const API_BASE_URL = 'http://localhost:8000/api';

// Função para fazer requisições HTTP
export async function apiRequest(endpoint, options = {}) {
  const url = `${API_BASE_URL}${endpoint}`;
  
  const defaultOptions = {
    credentials: "include",
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
      const errorData = await response.json().catch(() => ({}));
      const error = new Error(`HTTP error! status: ${response.status}`);
      error.response = errorData;
      error.status = response.status;
      throw error;
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
  
  // Buscar local por ID
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
  
  // Deletar local (exclusão lógica)
  async delete(id) {
    return apiRequest(`/local/${id}`, {
      method: 'DELETE',
    });
  },
  
  // Buscar imagens do local
  async getImages(localId) {
    return apiRequest(`/local/${localId}/imagens`);
  },
  
  // Buscar atividades do local
  async getActivities(localId) {
    return apiRequest(`/local/${localId}/atividades`);
  },
  
  // Buscar instalações do local
  async getFacilities(localId) {
    return apiRequest(`/local/${localId}/instalacoes`);
  },
  
  // Buscar avaliações do local
  async getRatings(localId) {
    return apiRequest(`/local/${localId}/avaliacoes`);
  },
};

// Serviços para Avaliações
export const ratingService = {
  // Criar nova avaliação
  async create(ratingData) {
    return apiRequest('/local-avaliacao', {
      method: 'POST',
      body: JSON.stringify(ratingData),
    });
  },

  // Atualizar avaliação
  async update(id, ratingData) {
    return apiRequest(`/local-avaliacao/${id}`, {
      method: 'PUT',
      body: JSON.stringify(ratingData),
    });
  },

  // Deletar avaliação
  async delete(id) {
    return apiRequest(`/local-avaliacao/${id}`, {
      method: 'DELETE',
    });
  },
};

// Serviços para Imagens
export const imageService = {
  // Upload de imagem
  async upload(imageData) {
    return apiRequest('/local-imagem', {
      method: 'POST',
      body: JSON.stringify(imageData),
    });
  },

  // Deletar imagem
  async delete(id) {
    return apiRequest(`/local-imagem/${id}`, {
      method: 'DELETE',
    });
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
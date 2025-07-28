// Serviço para imagens do local
import { apiRequest } from './api.js';

export const localImageService = {
  async addImage(id_local, imagemBase64) {
    return apiRequest('/local-imagem', {
      method: 'POST',
      body: JSON.stringify({
        id_local,
        imagem: imagemBase64,
        ativo: true
      })
    });
  },
  async deleteImage(localImagemId) {
    return apiRequest(`/local-imagem/${localImagemId}`, {
      method: 'DELETE'
    });
  }
};

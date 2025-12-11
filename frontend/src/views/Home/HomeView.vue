<template>
  <PesquisarLocal @abrir-dialog="abrirDialog" />
  <FiltroAtividades />

  <DialogCadastro
    :visible="visivelDialog"
    :tipo="tipoCadastro"
    @update:visible="visivelDialog = $event"
  />

  <!-- Loading state -->
  <div v-if="loading" class="loading-container">
    <div class="loading-spinner"></div>
    <p>Carregando locais...</p>
  </div>

  <!-- Error state -->
  <div v-else-if="error" class="error-container">
    <p>Erro ao carregar locais: {{ error }}</p>
    <button @click="loadLocais" class="retry-button">Tentar novamente</button>
  </div>

  <!-- Success state -->
  <div v-else style="display: flex; flex-wrap: wrap; gap: 24px; margin: 32px auto; max-width: 1400px; padding: 0 24px; justify-content: center;">
    <LocalCard
      v-for="local in locais"
      :key="local.id"
      :id="local.id"
      :activities="mapActivitiesForLocal(local)"
      :title="local.nome"
      :city="local.cidade"
      :state="local.estado"
      :rating="calculateRatingForLocal(local)"
      :owner="local.nome_proprietario"
      :phone="local.telefone_proprietario"
      :capacity="local.capacidade_pessoas"
      :facilities="mapFacilitiesForLocal(local)"
      :image="getImageForLocal(local)"
      @ver-detalhes="abrirDetalhes"
    />
  </div>

  <div v-if="detalhesVisiveis" class="modal-overlay" @click.self="fecharDetalhes">
    <div class="modal-content">
      <LocalInfo
        v-bind="localSelecionado"
        @edit="onEditLocal"
        @delete="onDeleteLocal"
      />
      <button class="modal-close" @click="fecharDetalhes">Fechar</button>
    </div>
  </div>

  <!-- Modal de Confirmação de Exclusão -->
  <ModalConfirmacaoInativacao
    :visible="modalConfirmarExclusao"
    titulo="Inativar Local"
    :texto="`Tem certeza que quer inativar o local '${localParaExcluir?.nome || ''}'? Esta ação não pode ser desfeita.`"
    @confirmar="confirmarExclusao"
    @cancelar="modalConfirmarExclusao = false"
  />

  <!-- <AtividadesTable /> -->

</template>

<script setup>
  import { ref, onMounted }         from "vue";
  import PesquisarLocal             from '@/components/Layout/PesquisarLocal.vue';
  import FiltroAtividades           from '@/components/Home/FiltroAtividades/FiltroAtividades.vue';
  import DialogCadastro             from '@/components/Dialogs/DialogCadastro/DialogCadastro.vue';
  import LocalCard                  from '@/components/Home/LocalCard/LocalCard.vue';
  import LocalInfo                  from '@/components/Home/LocalInfo/LocalInfo.vue';
  import ModalConfirmacaoInativacao from '@/components/Layout/ModalConfirmacaoInativacao.vue';
  import { localService, calculateAverageRating, mapActivities, mapFacilities } from '@/services/api.js';

  // Ícones SVG como string
  const JornadaIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>`;
  const AcampamentoIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 20L10 4M5 20l7-12 7 12z"/></svg>`;
  const DayUseIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>`;

  // Substituir os ícones SVG por PrimeIcons
  const activitiesIcons = {
    'Jornada': 'pi pi-users',
    'Acampamento': 'pi pi-home',
    'Day Use': 'pi pi-sun',
    'Futebol': 'pi pi-compass',
  };

  const visivelDialog = ref(false);
  const tipoCadastro  = ref("atividade");
  
  // Estados para dados dos locais
  const locais = ref([]);
  const loading = ref(false);
  const error = ref(null);

  function abrirDialog(tipo) {
    tipoCadastro.value  = tipo;
    visivelDialog.value = true;
  }

  // Modal de detalhes do local
  const detalhesVisiveis = ref(false);
  const localSelecionado = ref({});

  // Modal de confirmação de exclusão
  const modalConfirmarExclusao = ref(false);
  const localParaExcluir = ref(null);

  function abrirDetalhes(local) {
    localSelecionado.value = local;
    detalhesVisiveis.value = true;
  }
  
  function fecharDetalhes() {
    detalhesVisiveis.value = false;
    localSelecionado.value = {};
  }
  
  function onEditLocal() {
    // lógica para editar local
    alert('Editar local!');
  }
  
  function onDeleteLocal() {
    localParaExcluir.value = localSelecionado.value;
    modalConfirmarExclusao.value = true;
  }

  async function confirmarExclusao() {
    try {
      const localId = localParaExcluir.value.id;
      console.log('Tentando inativar local:', localId);
      
      const response = await localService.delete(localId);
      console.log('Resposta da inativação:', response);
      
      if (response.success || response.status) {
        modalConfirmarExclusao.value = false;
        localParaExcluir.value = null;
        alert('Local inativado com sucesso!');
        
        // Recarregar a lista de locais
        await loadLocais();
        
        // Fechar o modal de detalhes
        fecharDetalhes();
      } else {
        throw new Error(response.message || 'Erro desconhecido');
      }
    } catch (err) {
      console.error('Erro ao inativar local:', err);
      alert('Erro ao inativar local: ' + (err.message || 'Erro desconhecido'));
    }
  }

  // Função para carregar locais da API
  async function loadLocais() {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await localService.getAll();
      if (response.success) {
        locais.value = response.locais;
      } else {
        error.value = response.message || 'Erro ao carregar locais';
      }
    } catch (err) {
      console.error('Erro ao carregar locais:', err);
      error.value = 'Erro de conexão com o servidor';
    } finally {
      loading.value = false;
    }
  }

  // Função para mapear atividades de um local
  function mapActivitiesForLocal(local) {
    return local.atividades.map(activity => ({
      name: activity.nome,
      icon: activity.icone || 'pi pi-star' // Usar o ícone do backend
    }));
  }

  // Função para mapear instalações de um local
  function mapFacilitiesForLocal(local) {
    if (!local.instalacoes || local.instalacoes.length === 0) {
      return ['Banheiro', 'Energia', 'Internet', 'Rede Celular']; // Fallback
    }
    
    return local.instalacoes.map(facility => facility.nome);
  }

  // Função para calcular rating de um local
  function calculateRatingForLocal(local) {
    if (!local.avaliacoes || local.avaliacoes.length === 0) {
      return 0;
    }
    
    return calculateAverageRating(local.avaliacoes);
  }

  // Função para obter imagem de um local
  function getImageForLocal(local) {
    if (!local.imagens || local.imagens.length === 0) {
      // Imagens padrão baseadas no nome do local
      const defaultImages = {
        'Sala de Reuniões Principal': 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
        'Auditório Central': 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
        'Sala de Treinamento': 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80',
        'Espaço de Eventos': 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80',
        'Sala de Conferência': 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80',
      };
      
      return defaultImages[local.nome] || 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80';
    }
    
    // Se há imagens no backend, usar o endpoint para servir a primeira imagem
    const primeiraImagem = local.imagens[0];
    return primeiraImagem.imagem;
  }

  // Carregar locais quando o componente for montado
  onMounted(() => {
    loadLocais();
  });
</script>

<style scoped>
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  text-align: center;
  color: black;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #219653;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 16px;
  color: black;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  text-align: center;
  color: black;
}

.retry-button {
  background: #219653;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 16px;
}

.retry-button:hover {
  background: #1e8449;
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  min-width: 350px;
  max-width: 90vw;
  box-shadow: 0 4px 24px rgba(0,0,0,0.12);
  position: relative;
}
.modal-close {
  position: absolute;
  top: 12px;
  right: 12px;
  background: #e74c3c;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  font-size: 1.2rem;
  cursor: pointer;
}
</style>
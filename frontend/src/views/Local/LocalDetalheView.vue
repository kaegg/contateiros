<template>
  <div class="local-detalhe-prototipo">
    <!-- Header de Pesquisa -->
    <PesquisarLocal @abrir-dialog="abrirDialog" />

    <!-- Loading state -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Carregando local...</p>
    </div>

    <!-- Error state -->
    <div v-else-if="error" class="error-container">
      <h2>Erro ao carregar local</h2>
      <p>{{ error }}</p>
      <button @click="carregarLocal" class="retry-btn">Tentar novamente</button>
    </div>

    <!-- Local content -->
    <div v-else-if="local" class="local-content">
      <div class="local-detalhe-header">
        <div>
          <h1 class="local-title">
            {{ local.nome }}
            <span class="stars">
              <span v-for="i in 5" :key="i" :class="['star', { filled: i <= ratingMedio }]">★</span>
            </span>
          </h1>
          <div class="local-subtitle">{{ local.estado }} - {{ local.cidade }}</div>
          <button class="avaliar-btn" @click="scrollToComentario">Avaliar</button>
        </div>
      </div>
      
      <div class="local-detalhe-main">
        <div class="mapa-embed">
          <iframe
            class="local-mapa-iframe"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3689.234073289889!2d-46.71916768488544!3d-21.93472248551945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c9c7e2e2e2e2e2%3A0x2e2e2e2e2e2e2e2e!2s%C3%81guas%20da%20Prata%2C%20SP!5e0!3m2!1spt-BR!2sbr!4v1680000000000!5m2!1spt-BR!2sbr"
            width="100%"
            height="320"
            style="border:0; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.10); background: #eaeaea;"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
        <div class="local-detalhe-info">
          <LocalInfo
            :ownerName="local.nome_proprietario"
            :ownerPhone="local.telefone_proprietario"
            :capacity="local.capacidade_pessoas"
            :facilities="facilities"
            :activities="activities"
            :creator="local.usuario_criacao?.nome || 'Admin'"
            @edit="onEditLocal"
            @delete="onDeleteLocal"
          />
        </div>
      </div>
      
      <div class="local-detalhe-fotos" v-if="imagens.length > 0">
        <h3>Fotos do Local</h3>
        <div class="fotos-grid">
          <img v-for="(imagem, idx) in local.imagens" :key="idx" :src="imagem.imagem" class="foto" />
        </div>
      </div>

      <div class="local-detalhe-descricao" v-if="local.descricao">
        <h2>Descrição</h2>
        <p>{{ local.descricao }}</p>
      </div>

      <div class="local-detalhe-comentarios">
        <h3>Avaliações e Comentários</h3>
        <div class="comentarios-lista" v-if="avaliacoes.length > 0">
          <div v-for="avaliacao in avaliacoes" :key="avaliacao.id" class="comentario-item">
            <div class="comentario-nome">{{ avaliacao.usuario?.nome || 'Usuário' }}</div>
            <div class="comentario-estrelas">
              <span v-for="i in 5" :key="i" :class="['star', { filled: i <= avaliacao.avaliacao }]">★</span>
            </div>
            <div class="comentario-texto">{{ avaliacao.comentario }}</div>
          </div>
        </div>
        <div v-else class="sem-comentarios">
          <p>Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
        </div>
        <div class="comentario-novo" id="comentario-novo">
          <h3>Dê sua opinião!</h3>
          <div class="comentario-novo-estrelas">
            <span v-for="i in 5" :key="i" :class="['star', { filled: i <= novoComentarioEstrelas }]" @click="novoComentarioEstrelas = i">★</span>
          </div>
          <textarea v-model="novoComentarioTexto" placeholder="Faça um comentário..." class="comentario-novo-textarea" rows="2"></textarea>
          <button class="comentario-novo-btn" @click="enviarComentario" :disabled="enviandoComentario">
            {{ enviandoComentario ? 'Enviando...' : 'Comentar' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <DialogCadastroLocal
      :visible="visivelDialogEdicao"
      modo="edicao"
      :local="local"
      @update:visible="visivelDialogEdicao = $event"
    />

    <!-- Modal de Cadastro de Atividade -->
    <DialogCadastro
      v-if="modalCadastroVisivel && tipoCadastro === 'atividade'"
      :visible="modalCadastroVisivel"
      tipo="atividade"
      @update:visible="modalCadastroVisivel = $event"
    />

    <!-- Modal de Cadastro de Instalação -->
    <DialogCadastro
      v-if="modalCadastroVisivel && tipoCadastro === 'instalacao'"
      :visible="modalCadastroVisivel"
      tipo="instalacao"
      @update:visible="modalCadastroVisivel = $event"
    />

    <!-- Modal de Confirmação de Exclusão -->
    <ModalConfirmacaoInativacao
      :visible="modalConfirmarExclusao"
      titulo="Inativar Local"
      :texto="`Tem certeza que quer inativar o local '${local?.nome || ''}'? Esta ação não pode ser desfeita.`"
      @confirmar="confirmarExclusao"
      @cancelar="modalConfirmarExclusao = false"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed }    from 'vue';
import { useRoute, useRouter }         from 'vue-router';
import { localService, ratingService } from '@/services/api.js';
import LocalInfo                       from '@/components/Home/LocalInfo/LocalInfo.vue';
import DialogCadastroLocal             from '@/components/Dialogs/DialogCadastroLocal/DialogCadastroLocal.vue';
import ModalConfirmacaoInativacao      from '@/components/Layout/ModalConfirmacaoInativacao.vue';
import PesquisarLocal                  from '@/components/Layout/PesquisarLocal.vue';
import DialogCadastro                  from '@/components/Dialogs/DialogCadastro/DialogCadastro.vue';

// Tipos
interface Local {
  id: number;
  nome: string;
  cidade: string;
  estado: string;
  nome_proprietario: string;
  telefone_proprietario: string;
  descricao?: string;
  capacidade_pessoas: number;
  id_usuario_criacao: number;
  id_usuario_alteracao?: number;
  ativo: boolean;
  created_at: string;
  updated_at: string;
  usuario_criacao?: {
    id: number;
    nome: string;
  };
  usuario_alteracao?: {
    id: number;
    nome: string;
  };
  atividades?: Array<{
    id: number;
    nome: string;
    icone: string;
  }>;
  instalacoes?: Array<{
    id: number;
    nome: string;
  }>;
  imagens?: Array<{
    id: number;
    imagem: string;
  }>;
  avaliacoes?: Array<{
    id: number;
    avaliacao: number;
    comentario: string;
    usuario?: {
      id: number;
      nome: string;
    };
  }>;
}

interface Imagem {
  id: number;
  url: string;
}

interface Avaliacao {
  id: number;
  avaliacao: number;
  comentario: string;
  usuario?: {
    id: number;
    nome: string;
  };
}

const route = useRoute();
const router = useRouter();
const local = ref<Local | null>(null);
const loading = ref(true);
const error = ref<string | null>(null);
const imagens = ref<Imagem[]>([]);
const avaliacoes = ref<Avaliacao[]>([]);

// Dados para novo comentário
const novoComentarioTexto = ref('');
const novoComentarioEstrelas = ref(0);
const enviandoComentario = ref(false);

// Estados dos modais
const visivelDialogEdicao = ref(false);
const modalConfirmarExclusao = ref(false);
const modalCadastroVisivel = ref(false);
const tipoCadastro = ref('atividade');

// Computed properties
const ratingMedio = computed(() => {
  if (!avaliacoes.value || avaliacoes.value.length === 0) return 0;
  const sum = avaliacoes.value.reduce((total, av) => total + av.avaliacao, 0);
  return Math.round(sum / avaliacoes.value.length);
});

const activities = computed(() => {
  if (!local.value?.atividades) return [];
  return local.value.atividades.map(atividade => atividade.nome);
});

const facilities = computed(() => {
  if (!local.value?.instalacoes) return [];
  return local.value.instalacoes.map(instalacao => instalacao.nome);
});

// Funções
async function carregarLocal() {
  try {
    loading.value = true;
    error.value = null;
    
    const localId = route.params.id;
    const response = await localService.getById(localId);
    
    if (response.success) {
      local.value = response.local;
      
      // Carregar imagens
      try {
        const imagensResponse = await localService.getImages(localId);
        if (imagensResponse.success) {
          imagens.value = imagensResponse.imagens || [];
        }
      } catch (err) {
        console.warn('Erro ao carregar imagens:', err);
        imagens.value = [];
      }
      
      // Carregar avaliações
      try {
        const avaliacoesResponse = await localService.getRatings(localId);
        if (avaliacoesResponse.success) {
          avaliacoes.value = avaliacoesResponse.avaliacoes || [];
        }
      } catch (err) {
        console.warn('Erro ao carregar avaliações:', err);
        avaliacoes.value = [];
      }
    } else {
      error.value = response.message || 'Erro ao carregar local';
    }
  } catch (err: any) {
    console.error('Erro ao carregar local:', err);
    error.value = err.message || 'Erro ao carregar local';
  } finally {
    loading.value = false;
  }
}

function scrollToComentario() {
  const el = document.getElementById('comentario-novo');
  if (el) el.scrollIntoView({ behavior: 'smooth' });
}

function onEditLocal() {
  visivelDialogEdicao.value = true;
}

function onDeleteLocal() {
  modalConfirmarExclusao.value = true;
}

async function confirmarExclusao() {
  try {
    const localId = route.params.id;
    console.log('Tentando inativar local:', localId);
    
    const response = await localService.delete(localId);
    console.log('Resposta da inativação:', response);
    
    if (response.success || response.status) {
      modalConfirmarExclusao.value = false;
      alert('Local inativado com sucesso!');
      // Redirecionar para home
      router.push('/');
    } else {
      throw new Error(response.message || 'Erro desconhecido');
    }
  } catch (err: any) {
    console.error('Erro ao inativar local:', err);
    alert('Erro ao inativar local: ' + (err.message || 'Erro desconhecido'));
  }
}

function abrirDialog(tipo: string) {
  tipoCadastro.value = tipo;
  modalCadastroVisivel.value = true;
}

async function enviarComentario() {
  if (novoComentarioTexto.value.trim() && novoComentarioEstrelas.value > 0) {
    try {
      enviandoComentario.value = true;
      
      const localId = route.params.id;
      const ratingData = {
        id_local: localId,
        avaliacao: novoComentarioEstrelas.value,
        comentario: novoComentarioTexto.value,
        id_usuario: 1, // TODO: Pegar ID do usuário logado
        ativo: true
      };
      
      const response = await ratingService.create(ratingData);
      
      if (response.success) {
        // Recarregar avaliações
        const avaliacoesResponse = await localService.getRatings(localId);
        if (avaliacoesResponse.success) {
          avaliacoes.value = avaliacoesResponse.avaliacoes || [];
        }
        
        // Limpar formulário
        novoComentarioTexto.value = '';
        novoComentarioEstrelas.value = 0;
        
        alert('Avaliação enviada com sucesso!');
      } else {
        alert('Erro ao enviar avaliação: ' + (response.message || 'Erro desconhecido'));
      }
    } catch (err: any) {
      console.error('Erro ao enviar comentário:', err);
      alert('Erro ao enviar comentário: ' + (err.message || 'Erro desconhecido'));
    } finally {
      enviandoComentario.value = false;
    }
  } else {
    alert('Por favor, preencha todos os campos e selecione uma avaliação.');
  }
}

// Carregar dados quando o componente for montado
onMounted(() => {
  carregarLocal();
});
</script>

<style scoped>
.local-detalhe-prototipo {
  background: #f7f7f7;
  min-height: 100vh;
  padding: 0 0 32px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 400px;
  gap: 16px;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #219653;
  border-radius: 50%;
  animation: spin 1s linear infinite;
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
  min-height: 400px;
  gap: 16px;
  text-align: center;
}

.retry-btn {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}

.retry-btn:hover {
  background: #176b43;
}

.local-content {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.local-detalhe-header {
  width: 100%;
  max-width: 1100px;
  margin: 32px auto 0 auto;
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
}
.local-title {
  font-size: 2rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.2em;
  display: flex;
  align-items: center;
  gap: 8px;
}
.stars {
  font-size: 1.5rem;
  color: #FFC107;
  margin-left: 8px;
  letter-spacing: 1px;
  display: inline-block;
}
.star {
  color: #ccc;
  font-size: 1.5em;
  cursor: pointer;
  transition: color 0.2s;
  user-select: none;
}
.star.filled {
  color: #FFC107;
}
.local-subtitle {
  color: #444;
  font-size: 1.1rem;
  margin-bottom: 12px;
}
.avaliar-btn {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.3rem 1.1rem;
  font-size: 1rem;
  cursor: pointer;
  margin-bottom: 8px;
  margin-top: 2px;
  transition: background 0.2s;
}
.avaliar-btn:hover {
  background: #176b43;
}
.local-detalhe-main {
  display: flex;
  gap: 32px;
  max-width: 1100px;
  width: 100%;
  margin: 0 auto 0 auto;
  align-items: flex-start;
}
.mapa-embed {
  flex: 2;
  max-width: 650px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
  background: #eaeaea;
  display: block;
}
.local-mapa-iframe {
  width: 100%;
  height: 320px;
  border: 0;
  border-radius: 16px;
  background: #eaeaea;
  display: block;
}
.local-detalhe-info {
  flex: 1;
  margin-left: 24px;
}
.local-detalhe-fotos {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  width: 100%;
}
.local-detalhe-fotos h3 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 1rem;
}
.fotos-grid {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  margin-top: 0;
}
.foto {
  width: 260px;
  height: 170px;
  object-fit: cover;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  background: #eaeaea;
}
.local-detalhe-descricao {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem;
}
.local-detalhe-descricao h2 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.7em;
}
.local-detalhe-descricao p {
  color: #333;
  font-size: 1.05rem;
  margin-bottom: 1em;
}
.local-detalhe-comentarios {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem;
}
.local-detalhe-comentarios h3 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 1rem;
}
.sem-comentarios {
  text-align: center;
  padding: 2rem;
  color: #666;
  font-style: italic;
}
.comentarios-lista {
  display: flex;
  gap: 32px;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.comentario-item {
  min-width: 220px;
  max-width: 320px;
  flex: 1;
  background: #f7f7f7;
  border-radius: 8px;
  padding: 1rem 1.2rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.03);
  margin-bottom: 12px;
}
.comentario-nome {
  font-weight: 600;
  color: #222;
  margin-bottom: 0.2em;
}
.comentario-estrelas {
  margin-bottom: 0.5em;
}
.comentario-texto {
  color: #333;
  font-size: 1.05rem;
}
.comentario-novo {
  margin-top: 2rem;
  border-top: 1px solid #eee;
  padding-top: 1.5rem;
}
.comentario-novo h3 {
  font-size: 1.15rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.7em;
}
.comentario-novo-estrelas {
  margin-bottom: 0.7em;
}
.comentario-novo-textarea {
  width: 100%;
  border-radius: 6px;
  border: 1px solid #ccc;
  padding: 0.7em;
  font-size: 1rem;
  margin-bottom: 0.7em;
  resize: vertical;
  background: #f7f7f7;
  color: #222;
}
.comentario-novo-btn {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.comentario-novo-btn:hover:not(:disabled) {
  background: #176b43;
}
.comentario-novo-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.18);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.modal-confirm {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.13);
  min-width: 420px;
  max-width: 90vw;
  padding: 0;
  overflow: hidden;
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 1.1rem;
  font-weight: 600;
  padding: 1rem 1.2rem 0.5rem 1.2rem;
  border-bottom: 1px solid #eee;
}
.modal-header span {
  color: #222;
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #444;
}
.modal-body {
  padding: 1.2rem 1.2rem 0.5rem 1.2rem;
  font-size: 1.08rem;
  color: #222;
}
.modal-actions {
  display: flex;
  gap: 1rem;
  padding: 1rem 1.2rem 1.2rem 1.2rem;
}
.btn-sim {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-sim:hover {
  background: #176b43;
}
.btn-cancelar {
  background: #fff;
  color: #222;
  border: 1px solid #bbb;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-cancelar:hover {
  background: #f2f2f2;
}
@media (max-width: 1100px) {
  .local-detalhe-main, .local-detalhe-header, .local-detalhe-fotos {
    max-width: 98vw;
  }
  .foto {
    width: 45vw;
    min-width: 160px;
  }
}
@media (max-width: 900px) {
  .local-detalhe-main {
    flex-direction: column;
    gap: 24px;
  }
  .local-detalhe-info {
    margin-left: 0;
  }
  .fotos-grid {
    justify-content: center;
  }
}
</style> 
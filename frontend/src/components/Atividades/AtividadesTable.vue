<template>
  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="atividades-table-container">
    <h1 class="logs-title">Atividades</h1>
    <DialogCadastro
      v-if="showEditDialog"
      :visible="showEditDialog"
      tipo="atividade"
      titulo="Editar atividade"
      :dados-edicao="atividadeParaEditar"
      @update:visible="showEditDialog = $event"
      @editado="onAtividadeEditada"
    />
    <ModalConfirmacaoInativacao
      :visible="showDeleteDialog"
      titulo="Ativar/Inativar atividade"
      :texto="atividadeParaExcluir?.status
            ? `Tem certeza que quer ${atividadeParaExcluir.status === 'Ativo' ? 'inativar' : 'ativar'} a atividade '${atividadeParaExcluir.nome}'?`
            : ''"
      @confirmar="toggleAtivo"
      @cancelar="showDeleteDialog = false"
    />
    <div class="table-header">
      <div class="table-controls">
        <label class="mostrar-label">
          Mostrar
          <select v-model="rowsPerPage" class="rows-dropdown">
            <option v-for="opt in [10, 20, 50]" :key="opt" :value="opt">{{ opt }}</option>
          </select>
          Atividades
        </label>
        <input
          v-model="search"
          class="search-bar"
          type="text"
          placeholder="Pesquisar Atividades..."
        />
      </div>
    </div>
    <table class="atividades-table">
      <thead>
        <tr>
          <th>Código Atividade</th>
          <th>Ícone</th>
          <th>Atividade</th>
          <th>Status</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="atividade in paginatedAtividades" :key="atividade.codigo">
          <td>{{ atividade.codigo }}</td>
          <td>
            <span class="icone-wrapper">
              <img :src="atividade.icone" class="atividade-icone" v-if="atividade.icone.startsWith('data:') || atividade.icone.startsWith('http')" />
              <i :class="['atividade-icone', atividade.icone]" v-else />
            </span>
          </td>
          <td>{{ atividade.nome }}</td>
          <td>
            <span :class="['status', atividade.status === 'Ativo' ? 'ativo' : 'inativo']">
              {{ atividade.status }}
            </span>
          </td>
          <td class="actions">
            <button class="action-btn edit" title="Editar" @click="openEditDialog(atividade)">
              <svg width="18" height="18" fill="none" stroke="#3B82F6" stroke-width="2"><path d="M4 13.5V16h2.5l7.1-7.1-2.5-2.5L4 13.5z"/><path d="M14.7 6.3a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0l-1.1 1.1 2.5 2.5 1.1-1.1z"/></svg>
            </button>

            <ToggleSwitch 
              :model-value="atividade.status === 'Ativo'" 
              :on-label="'Ativo'" 
              :off-label="'Inativo'" 
              @click="(e) => handleSwitchClick(e, atividade)"
            >
              <template #handle="{ checked }">
                <i :class="['!text-xs pi', { 'pi-check': checked, 'pi-times': !checked }]" />
              </template>
            </ToggleSwitch>
          </td>
        </tr>
        <tr v-if="paginatedAtividades.length === 0">
          <td colspan="5" class="no-results">Nenhuma atividade encontrada.</td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <button :disabled="currentPage === 1" @click="currentPage--">Anterior</button>
      <button
        v-for="page in totalPages"
        :key="page"
        :class="{ active: page === currentPage }"
        @click="currentPage = page"
      >{{ page }}</button>
      <button :disabled="currentPage === totalPages" @click="currentPage++">Próximo</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch }   from 'vue'
import DialogCadastro             from '@/components/Dialogs/DialogCadastro/DialogCadastro.vue';
import ModalConfirmacaoInativacao from '@/components/Layout/ModalConfirmacaoInativacao.vue';
import { onMounted }              from 'vue'
import axios                      from '@/services/axios'
import { useToast }               from 'primevue/usetoast'
import ToggleSwitch               from 'primevue/toggleswitch';

const atividades = ref([]);
const toast      = useToast();
const isLoading  = ref(false);

async function buscarAtividades() {
  isLoading.value = true;
  
  try {
    const response = await axios.get('/atividade')
    const data = response.data.atividades
    atividades.value = data.map(a => ({
      id: a.id,
      codigo: a.codigo,
      nome: a.nome,
      status: a.ativo ? 'Ativo' : 'Inativo',
      icone: a.icone
    }))
  } catch (error) {
    console.error('Erro ao buscar atividades:', error)
  }finally {
    isLoading.value = false;
  }
}

onMounted(buscarAtividades);

const search = ref('')
const rowsPerPage = ref(10)
const currentPage = ref(1)
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);
const atividadeParaExcluir = ref(null);
const atividadeParaEditar = ref(null);

function onAtividadeEditada() {
  buscarAtividades();
}

function handleSwitchClick(event, atividade) {
  atividadeParaExcluir.value = { ...atividade, id: atividade.id };
  showDeleteDialog.value     = true;

  event.preventDefault();
}

async function toggleAtivo() {
  if (!atividadeParaExcluir.value) return;

  showDeleteDialog.value = false;

  try {
    let response;

    if(atividadeParaExcluir.value.status == "Ativo"){

      response = await axios.delete(`http://localhost:8000/api/atividade/${atividadeParaExcluir.value.id}`);

    }else{

      response = await axios.put(`http://localhost:8000/api/atividade/ativar/${atividadeParaExcluir.value.id}`);

    }

    toast.add({
      severity: 'success',
      summary: response.data.message,
      life: 3000
    });

    await buscarAtividades();
  } catch (error) {
    toast.add({
      severity: 'error',
      summary: 'Erro ao inativar atividade',
      detail: error.message,
      life: 3000
    });
  }
}

const filteredAtividades = computed(() => {
  if (!search.value) return atividades.value
  return atividades.value.filter(a =>
    a.codigo.toLowerCase().includes(search.value.toLowerCase()) ||
    a.nome.toLowerCase().includes(search.value.toLowerCase())
  )
})

const totalPages = computed(() =>
  Math.ceil(filteredAtividades.value.length / rowsPerPage.value) || 1
)

const paginatedAtividades = computed(() => {
  const start = (currentPage.value - 1) * rowsPerPage.value
  return filteredAtividades.value.slice(start, start + rowsPerPage.value)
})

watch([search, rowsPerPage], () => {
  currentPage.value = 1
})
</script>

<style scoped>
@import '../../assets/css/gridSwitch.css';

.atividades-table-container {
  background: #fff;
  border-radius: 8px;
  padding: 32px 0 0 0;
  box-shadow: 0 2px 8px #0001;
  width: 100%;
  max-width: 1100px;
  margin: 0 auto;
}

.table-header {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding: 0 32px 16px 32px;
}

.table-controls {
  display: flex;
  align-items: center;
  gap: 16px;
  width: 100%;
}

.mostrar-label {
  font-size: 14px;
  color: #222;
  display: flex;
  align-items: center;
  gap: 6px;
}

.rows-dropdown {
  margin: 0 6px;
  padding: 2px 8px;
  border-radius: 4px;
  border: 1px solid #ddd;
  font-size: 14px;
}

.search-bar {
  flex: 1;
  padding: 6px 12px;
  border-radius: 6px;
  border: 1px solid #ddd;
  font-size: 14px;
  background: #f7f7f7;
  color: #222;
}

.search-bar::placeholder {
  color: #888;
  opacity: 1;
}

.atividades-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin: 0;
}

.atividades-table th, .atividades-table td {
  padding: 14px 0;
  text-align: center;
  font-size: 15px;
  color: #222;
}

.atividades-table th {
  background: #f5f5f5;
  font-weight: 600;
  color: #222;
  border-bottom: 2px solid #e5e5e5;
}

.atividades-table tbody tr {
  background: #fff;
  border-bottom: 1px solid #f0f0f0;
}

.atividades-table tbody tr:last-child {
  border-bottom: none;
}

.icone-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
}

.status {
  display: inline-block;
  padding: 2px 12px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 500;
}

.status.ativo {
  background: #e7fbe9;
  color: #22c55e;
}

.status.inativo {
  background: #fde7e7;
  color: #ef4444;
}

.action-btn {
  background: none;
  border: none;
  cursor: pointer;
  margin: 0 2px;
  padding: 2px;
  vertical-align: middle;
  transition: background 0.2s;
  border-radius: 4px;
}

.action-btn.edit:hover {
  background: #e0f2fe;
}

.action-btn.delete:hover {
  background: #fee2e2;
}

.no-results {
  text-align: center;
  color: #888;
  font-size: 15px;
  padding: 24px 0;
}

.pagination {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  gap: 4px;
  padding: 24px 0 32px 32px;
}

.pagination button {
  background: #f5f5f5;
  border: none;
  border-radius: 4px;
  padding: 4px 12px;
  margin: 0 2px;
  font-size: 14px;
  cursor: pointer;
  color: #222;
  transition: background 0.2s;
}

.pagination button.active,
.pagination button:hover:not(:disabled) {
  background: #d1fae5;
  color: #059669;
}

.pagination button:disabled {
  background: #eee;
  color: #bbb;
  cursor: not-allowed;
}

.atividade-icone {
  font-size: 1.7rem;
  color: #22c55e;
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

.modal-confirm {
  background: #fff;
  border-radius: 16px;
  padding: 2rem;
  min-width: 350px;
  max-width: 90vw;
  box-shadow: 0 4px 24px rgba(0,0,0,0.12);
  position: relative;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 1.2rem;
  font-weight: 600;
  color: #222;
  margin-bottom: 1.5rem;
}

.modal-title {
  font-weight: bold;
  font-size: 1.25rem;
  color: #222;
}

.modal-close {
  background: none;
  border: none;
  color: #888;
  font-size: 1.5rem;
  cursor: pointer;
  margin-left: 12px;
}

.modal-body {
  color: #222;
  margin-bottom: 2rem;
  font-size: 1.1rem;
}

.modal-actions {
  display: flex;
  gap: 16px;
  justify-content: flex-start;
}

.btn-sim {
  background: #22c55e;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.6rem 2.2rem;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-sim:hover {
  background: #16a34a;
}
.btn-cancelar {
  background: #fff;
  color: #222;
  border: 1.5px solid #c1c7cd;
  border-radius: 8px;
  padding: 0.6rem 2.2rem;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, border 0.2s;
}

.btn-cancelar:hover {
  background: #f3f4f6;
  border-color: #a3a3a3;
}

.logs-title {
  text-align: center;
  font-size: 2.3rem;
  font-weight: bold;
  margin-bottom: 18px;
  margin-top: 0;
  color: #222;
}
</style> 
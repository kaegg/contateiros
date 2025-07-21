<template>
  <div class="atividades-table-container">
    <h1 class="logs-title">Atividades</h1>
    <DialogCadastro
      v-if="showEditDialog"
      :visible="showEditDialog"
      tipo="atividade"
      titulo="Editar atividade"
      @update:visible="showEditDialog = $event"
    />
    <ModalConfirmacaoInativacao
      :visible="showDeleteDialog"
      titulo="Inativar atividade"
      :texto="`Tem certeza que quer inativar a atividade '${atividadeParaExcluir?.nome}'`"
      @confirmar="confirmarExclusao"
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
              <i :class="['atividade-icone', atividade.icone]" />
            </span>
          </td>
          <td>{{ atividade.nome }}</td>
          <td>
            <span :class="['status', atividade.status === 'Ativo' ? 'ativo' : 'inativo']">
              {{ atividade.status }}
            </span>
          </td>
          <td>
            <button class="action-btn edit" title="Editar" @click="openEditDialog(atividade)">
              <svg width="18" height="18" fill="none" stroke="#3B82F6" stroke-width="2"><path d="M4 13.5V16h2.5l7.1-7.1-2.5-2.5L4 13.5z"/><path d="M14.7 6.3a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0l-1.1 1.1 2.5 2.5 1.1-1.1z"/></svg>
            </button>
            <button class="action-btn delete" title="Excluir" @click="openDeleteDialog(atividade)">
              <svg width="18" height="18" fill="none" stroke="#EF4444" stroke-width="2"><rect x="3" y="6" width="12" height="9" rx="2"/><path d="M8 9v3M10 9v3M5 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/></svg>
            </button>
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
import { ref, computed, watch } from 'vue'
import DialogCadastro from '@/components/DialogCadastro/DialogCadastro.vue';
import ModalConfirmacaoInativacao from '@/components/ModalConfirmacaoInativacao.vue';

// Substituir os ícones SVG por PrimeIcons conforme o filtro de atividades
const atividades = ref([
  { codigo: '#ACMPMNT1', icone: 'pi pi-home', nome: 'Acampamento', status: 'Ativo' },
  { codigo: '#JRND1', icone: 'pi pi-users', nome: 'Jornada', status: 'Ativo' },
  { codigo: '#DS1', icone: 'pi pi-sun', nome: 'Day Use', status: 'Ativo' },
  { codigo: '#FTBL1', icone: 'pi pi-compass', nome: 'Futebol', status: 'Inativo' },
])

const search = ref('')
const rowsPerPage = ref(10)
const currentPage = ref(1)
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);
const atividadeParaExcluir = ref(null);

function openEditDialog(atividade) {
  showEditDialog.value = true;
}
function openDeleteDialog(atividade) {
  atividadeParaExcluir.value = atividade;
  showDeleteDialog.value = true;
}
function confirmarExclusao() {
  showDeleteDialog.value = false;
  // Aqui pode ser implementada a lógica real de exclusão
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
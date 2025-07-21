<template>
  <div class="atividades-table-container">
    <h1 class="logs-title">Logs de alteração</h1>
    <div class="table-header">
      <div class="table-controls">
        <label class="mostrar-label">
          Mostre
          <select v-model="rowsPerPage" class="rows-dropdown">
            <option v-for="opt in [10, 20, 50]" :key="opt" :value="opt">{{ opt }}</option>
          </select>
          Entradas
        </label>
        <input
          v-model="search"
          class="search-bar"
          type="text"
          placeholder="Pesquisar Entrada..."
        />
      </div>
    </div>
    <table class="atividades-table">
      <thead>
        <tr>
          <th>Nome do usuário</th>
          <th>Data</th>
          <th>Campo alterado</th>
          <th>Tipo de operação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="log in paginatedLogs" :key="log.id">
          <td>{{ log.usuario }}</td>
          <td>{{ log.data }}</td>
          <td>{{ log.campo || '--' }}</td>
          <td>
            <span :class="['tipo-operacao', log.tipoClass]" v-html="log.tipo"></span>
          </td>
        </tr>
        <tr v-if="paginatedLogs.length === 0">
          <td colspan="4" class="no-results">Nenhum log encontrado.</td>
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

const logs = ref([
  { id: 1, usuario: 'Raphael Ichiro', data: '13/05/2025 13:20', campo: '', tipo: 'Criação de local (Parque do Ingá)', tipoClass: 'tipo-criacao' },
  { id: 2, usuario: 'Kauan Eguchi', data: '06/09/2025 14:29', campo: '', tipo: 'Criação de local (Circuito Inter Parques Curitiba)', tipoClass: 'tipo-criacao' },
  { id: 3, usuario: 'Henrique Maeda', data: '25/09/2025 10:59', campo: '', tipo: 'Criação de local (Travessia Poços de Caldas)', tipoClass: 'tipo-criacao' },
  { id: 4, usuario: 'Leonardo Almenara', data: '06/09/2025 09:01', campo: '', tipo: 'Criação de local (Travessia Lapinha Tabueiros)', tipoClass: 'tipo-criacao' },
  { id: 5, usuario: 'Henrique Maeda', data: '25/09/2025 11:30', campo: 'Instalações', tipo: 'Edição de local (Travessia Poços de Caldas)', tipoClass: 'tipo-edicao' },
  { id: 6, usuario: 'Admin', data: '06/09/2025 10:40', campo: '', tipo: 'Remoção de local (UEM - Campus Maringá)', tipoClass: 'tipo-remocao' },
])

const search = ref('')
const rowsPerPage = ref(10)
const currentPage = ref(1)

const filteredLogs = computed(() => {
  if (!search.value) return logs.value
  return logs.value.filter(l =>
    l.usuario.toLowerCase().includes(search.value.toLowerCase()) ||
    l.data.toLowerCase().includes(search.value.toLowerCase()) ||
    (l.campo && l.campo.toLowerCase().includes(search.value.toLowerCase())) ||
    l.tipo.toLowerCase().includes(search.value.toLowerCase())
  )
})

const totalPages = computed(() =>
  Math.ceil(filteredLogs.value.length / rowsPerPage.value) || 1
)

const paginatedLogs = computed(() => {
  const start = (currentPage.value - 1) * rowsPerPage.value
  return filteredLogs.value.slice(start, start + rowsPerPage.value)
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
.logs-title {
  text-align: center;
  font-size: 2.3rem;
  font-weight: bold;
  margin-bottom: 18px;
  margin-top: 0;
  color: #222;
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
.tipo-operacao {
  font-size: 15px;
  font-weight: 500;
  padding: 2px 10px;
  border-radius: 8px;
  display: inline-block;
}
.tipo-criacao {
  background: #e7fbe9;
  color: #22c55e;
}
.tipo-edicao {
  background: #e0e7ff;
  color: #2563eb;
}
.tipo-remocao {
  background: #fde7e7;
  color: #ef4444;
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
</style> 
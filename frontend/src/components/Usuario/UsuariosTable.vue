<template>
  <div class="atividades-table-container">
    <Toast />
    <h1 class="logs-title">Usuários</h1>
    <ModalEditarUsuario
      v-if="showEditModal"
      :visible="showEditModal"
      :usuario="usuarioSelecionado"
      :funcoes="funcoes"
      :secoes="secoes"
      @update:visible="closeEditModal"
      @usuarioEditado="buscarUsuarios"
    />
    <ModalConfirmacaoInativacao
      :visible="showDeleteModal"
      titulo="Inativar usuário"
      :texto="`Tem certeza que quer inativar o usuário '${usuarioParaInativar?.nome}'?`"
      @confirmar="inativarUsuario"
      @cancelar="closeDeleteModal"
    />
    <div class="table-header">
      <div class="table-controls">
        <label class="mostrar-label">
          Mostrar
          <select v-model="rowsPerPage" class="rows-dropdown">
            <option v-for="opt in [10, 20, 50]" :key="opt" :value="opt">{{ opt }}</option>
          </select>
          Usuários
        </label>
        <input
          v-model="search"
          class="search-bar"
          type="text"
          placeholder="Pesquisar Usuários..."
        />
      </div>
    </div>
    <table class="atividades-table">
      <thead>
        <tr>
          <th>Código Usuário</th>
          <th>Usuário</th>
          <th>Data de cadastro</th>
          <th>Perfil</th>
          <th>Status</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="usuario in paginatedUsuarios" :key="usuario.id">
          <td>{{ usuario.id }}</td>
          <td>{{ usuario.nome }}</td>
          <td>{{ formatarDataBrasileira(usuario.created_at) }}</td>
          <td>{{ usuario.funcao.nome }}</td>
          <td>
            <span :class="['status', usuario.ativo ? 'ativo' : 'inativo']">
              {{ usuario.ativo ? 'Ativo' : 'Inativo' }}
            </span>
          </td>
          <td>
            <button class="action-btn edit" title="Editar" @click="openEditModal(usuario)">
              <svg width="18" height="18" fill="none" stroke="#3B82F6" stroke-width="2"><path d="M4 13.5V16h2.5l7.1-7.1-2.5-2.5L4 13.5z"/><path d="M14.7 6.3a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0l-1.1 1.1 2.5 2.5 1.1-1.1z"/></svg>
            </button>
            <button class="action-btn delete" title="Inativar" @click="openDeleteModal(usuario)">
              <svg width="18" height="18" fill="none" stroke="#EF4444" stroke-width="2"><rect x="3" y="6" width="12" height="9" rx="2"/><path d="M8 9v3M10 9v3M5 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/></svg>
            </button>
          </td>
        </tr>
        <tr v-if="paginatedUsuarios.length === 0">
          <td colspan="6" class="no-results">Nenhum usuário encontrado.</td>
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

<script setup lang="ts">
  import { ref, computed, watch, onMounted, reactive } from 'vue'
  import ModalEditarUsuario from '@/components/Usuario/ModalEditarUsuario.vue';
  import ModalConfirmacaoInativacao from '@/components/Layout/ModalConfirmacaoInativacao.vue';
  import axios                        from 'axios';
  import { useToast }                 from 'primevue/usetoast';
  import Toast from 'primevue/toast';

  type Usuario = {
    id: number;
    nome: string;
    usuario: string;
    email: string;
    telefone: string;
    id_funcao: number;
    id_secao: number;
    ativo: boolean;
    funcao: Funcao;
    secao: Secao;
    created_at: string;
    updated_at: string;
    // add other fields as needed
  };

  type Funcao = {
    id: number;
    nome: string;
  };

  type Secao = {
    id: number;
    nome: string;
  };

  const toast      = useToast();
  const users      = ref<Usuario[]>([]);
  const funcoes    = ref<Funcao[]>([]);
  const secoes     = ref<Secao[]>([]);
  const isLoading  = ref(false);
  const formErrors = ref<{ [key: string]: string[] }>({});
  const isInativando = ref(false);

  const buscarUsuarios = async () => {
    isLoading.value = true;
    try {
      const usersResp = await axios.get("http://localhost:8000/api/usuario");
      if (usersResp.data.success) {
        users.value = usersResp.data.usuarios;
        funcoes.value = [
          ...new Map(users.value.map(u => [u.funcao.id, u.funcao])).values()
        ];
        secoes.value = [
          ...new Map(users.value.map(u => [u.secao.id, u.secao])).values()
        ];
      } else {
        toast.add({
          severity: 'error',
          summary : 'Ocorreu um erro ao buscar usuários.',
          life    : 3000
        });
      }
    } catch (error) {
      toast.add({
        severity: 'error',
        summary : 'Ocorreu um erro ao buscar dados de usuários, por favor recarregue a página e tente novamente.',
        life    : 4000
      });
    } finally {
      isLoading.value = false;
    }
  };

  onMounted(buscarUsuarios);


const search = ref('')
const rowsPerPage = ref(10)
const currentPage = ref(1)

const showEditModal = ref(false);
const usuarioSelecionado = ref<Usuario | null>(null);

function openEditModal(usuario: Usuario) {
  // Garante que funcao e secao referenciem os objetos corretos das listas funcoes/secoes
  const funcaoSelecionada = funcoes.value.find(f => f.id === usuario.funcao.id) || usuario.funcao;
  const secaoSelecionada = secoes.value.find(s => s.id === usuario.secao.id) || usuario.secao;
  usuarioSelecionado.value = { ...usuario, funcao: funcaoSelecionada, secao: secaoSelecionada };
  showEditModal.value = true;
}
function closeEditModal(val: boolean) {
  showEditModal.value = val;
  if (!val) usuarioSelecionado.value = null;
}

const showDeleteModal = ref(false);
const usuarioParaInativar = ref<Usuario | null>(null);

function openDeleteModal(usuario: Usuario) {
  usuarioParaInativar.value = usuario;
  showDeleteModal.value = true;
}
function closeDeleteModal() {
  showDeleteModal.value = false;
  usuarioParaInativar.value = null;
}

async function inativarUsuario() {
  if (!usuarioParaInativar.value) return;
  isInativando.value = true;
  try {
    await axios.delete(`http://localhost:8000/api/usuario/${usuarioParaInativar.value.id}`);
    toast.add({
      severity: 'success',
      summary: 'Usuário inativado com sucesso!',
      life: 3000
    });
    buscarUsuarios();
  } catch (error: any) {
    toast.add({
      severity: 'error',
      summary: 'Erro ao inativar usuário',
      detail: error.message,
      life: 3000
    });
  } finally {
    isInativando.value = false;
    closeDeleteModal();
  }
}

function formatarDataBrasileira(dataIso: string) {
  if (!dataIso) return '';
  const data = new Date(dataIso);
  const dia = String(data.getDate()).padStart(2, '0');
  const mes = String(data.getMonth() + 1).padStart(2, '0');
  const ano = data.getFullYear();
  const hora = String(data.getHours()).padStart(2, '0');
  const min = String(data.getMinutes()).padStart(2, '0');
  return `${dia}/${mes}/${ano} ${hora}:${min}`;
}

const filteredUsuarios = computed(() => {
  if (!search.value) return users.value
  return users.value.filter(u =>
    u.id.toString().includes(search.value) ||
    u.nome.toLowerCase().includes(search.value.toLowerCase()) ||
    u.usuario.toLowerCase().includes(search.value.toLowerCase()) ||
    u.email.toLowerCase().includes(search.value.toLowerCase()) ||
    u.telefone.toLowerCase().includes(search.value.toLowerCase()) ||
    u.id_funcao.toString().includes(search.value) ||
    u.id_secao.toString().includes(search.value) ||
    u.ativo.toString().includes(search.value)
  )
})

const totalPages = computed(() =>
  Math.ceil(filteredUsuarios.value.length / rowsPerPage.value) || 1
)

const paginatedUsuarios = computed(() => {
  const start = (currentPage.value - 1) * rowsPerPage.value
  return filteredUsuarios.value.slice(start, start + rowsPerPage.value)
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
  overflow-x: hidden;
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
  table-layout: fixed;
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
</style> 
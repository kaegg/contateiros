<template>
  <div class="card flex justify-center">
    <Toast />
    <Loader :isLoading="isLoading" />
    <Dialog
      :visible="visible"
      modal
      :header="'Editar Usuário'"
      @update:visible="emit('update:visible', $event)"
      class="bg-white! text-black!"
    >
      <Form class="pt-4" @submit="editarUsuario">
        <div class="titulo-nome">{{ usuario.nome }}</div>
        <div class="grid grid-cols-2 gap-6">
          <FloatLabel>
            <InputText
              id="login"
              v-model="usuario.usuario"
              :placeholder="isCampoFocused.login ? 'Ex.: usuario123' : undefined"
              @focus="isCampoFocused.login = true"
              @blur="isCampoFocused.login = false"
              class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
            />
            <label for="login" class="text-black">Nome de usuário (login)</label>
            <Message v-if="formErrors.usuario" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.usuario[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel>
            <InputText
              id="nomeCompleto"
              v-model="usuario.nome"
              :placeholder="isCampoFocused.nomeCompleto ? 'Ex.: João da Silva' : undefined"
              @focus="isCampoFocused.nomeCompleto = true"
              @blur="isCampoFocused.nomeCompleto = false"
              class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
            />
            <label for="nomeCompleto" class="text-black">Nome completo</label>
            <Message v-if="formErrors.nome" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.nome[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel>
            <InputText
              id="email"
              v-model="usuario.email"
              :placeholder="isCampoFocused.email ? 'Ex.: email@contateiros.com.br' : undefined"
              @focus="isCampoFocused.email = true"
              @blur="isCampoFocused.email = false"
              class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
            />
            <label for="email" class="text-black">E-mail</label>
            <Message v-if="formErrors.email" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.email[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel>
            <InputText
              id="telefone"
              v-model="usuario.telefone"
              :placeholder="isCampoFocused.telefone ? 'Ex.: (44) 9 9999-9999' : undefined"
              @focus="isCampoFocused.telefone = true"
              @blur="isCampoFocused.telefone = false"
              class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
            />
            <label for="telefone" class="text-black">Telefone</label>
            <Message v-if="formErrors.telefone" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.telefone[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel>
            <Dropdown
              id="funcao"
              v-model="usuario.funcao"
              :options="funcoes"
              optionLabel="nome"
              placeholder="Selecione a função"
              @focus="isCampoFocused.funcao = true"
              @blur="isCampoFocused.funcao = false"
              class="w-full bg-transparent! border! border-black! text-black! rounded-xl! mt-1 mb-1 custom-dropdown"
              :class="{'p-filled': !!usuario.funcao}"
            />
            <label for="funcao" class="text-black!">Função</label>
            <Message v-if="formErrors.id_funcao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.id_funcao[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel>
            <Dropdown
              id="secao"
              v-model="usuario.secao"
              :options="secoes"
              optionLabel="nome"
              placeholder="Selecione a seção"
              @focus="isCampoFocused.secao = true"
              @blur="isCampoFocused.secao = false"
              class="w-full bg-transparent! border! border-black! text-black! rounded-xl! mt-1 mb-1 custom-dropdown"
              :class="{'p-filled': !!usuario.secao}"
            />
            <label for="secao" class="text-black!">Seção</label>
            <Message v-if="formErrors.id_secao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.id_secao[0] }}
            </Message>
          </FloatLabel>
          <FloatLabel v-if="!props.usuario.ativo">
            <Dropdown
              v-model="statusAtivo"
              :options="[{label: 'Ativo', value: true}, {label: 'Inativo', value: false}]"
              optionLabel="label"
              optionValue="value"
              placeholder="Selecione o status"
              class="w-full bg-transparent! border! border-black! text-black! rounded-xl! mt-1 mb-1"
            />
            <label for="status" class="text-black!">Status</label>
          </FloatLabel>
        </div>
        <div class="flex justify-start gap-4 mt-8">
          <Button class="btSalvar text-white px-4! py-2! rounded-2xl!" :disabled="isLoading" type="submit">Atualizar</Button>
          <Button class="text-green-700! border border-green-700! bg-white! hover:bg-green-50! hover:border-green-800! px-4! py-2! rounded-2xl!" @click.prevent="emit('update:visible', false)">Cancelar</Button>
        </div>
      </Form>
    </Dialog>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, reactive, ref, watch } from 'vue';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';
import { Form } from '@primevue/forms';
import Toast from 'primevue/toast';
import Loader from '@/components/Loader.vue';
import Message from 'primevue/message';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
  visible: Boolean,
  usuario: {
    type: Object,
    default: () => ({
      nome: '', usuario: '', email: '', telefone: '', funcao: { id: null, nome: '' }, secao: { id: null, nome: '' }
    })
  },
  funcoes: {
    type: Array,
    default: () => []
  },
  secoes: {
    type: Array,
    default: () => []
  }
});
const emit = defineEmits(['update:visible', 'usuarioEditado']);

const isCampoFocused = reactive({
  login: false,
  nomeCompleto: false,
  email: false,
  telefone: false,
  funcao: false,
  secao: false
});

const statusAtivo = ref(props.usuario.ativo !== undefined ? props.usuario.ativo : true);

watch(() => props.usuario, (novoUsuario) => {
  statusAtivo.value = novoUsuario.ativo !== undefined ? novoUsuario.ativo : true;
});

const isLoading = ref(false);
const formErrors = ref({});
const toast = useToast();

watch(() => props.visible, (val) => {
  if (val) {
    formErrors.value = {};
  }
});

const editarUsuario = async () => {
  isLoading.value = true;
  try {
    const data = {
      usuario  : props.usuario.usuario,
      nome     : props.usuario.nome,
      email    : props.usuario.email,
      telefone : props.usuario.telefone.replace(/\D/g, ''),
      id_funcao: props.usuario.funcao ? props.usuario.funcao.id : null,
      id_secao : props.usuario.secao ? props.usuario.secao.id : null,
      ativo    : statusAtivo.value
    };
    await axios.put(`http://localhost:8000/api/usuario/${props.usuario.id}`, data);
    formErrors.value = {};
    toast.add({
      severity: 'success',
      summary : 'Usuário atualizado com sucesso!',
      life    : 3000
    });
    emit('usuarioEditado');
    emit('update:visible', false);
  } catch (error) {
    if (error.response?.status === 422) {
      const backendErrors   = error.response.data.errors;
      const errosFormulario = {};
      for (const field in backendErrors) {
        errosFormulario[field] = backendErrors[field].map((msg) => ({ message: msg }));
      }
      setErrors(errosFormulario);
    } else {
      toast.add({
        severity: 'error',
        summary: 'Erro ao atualizar usuário',
        detail: error.message,
        life: 3000
      });
    }
  } finally {
    isLoading.value = false;
  }
};

function setErrors(errors) {
  const mapped = {};
  for (const field in errors) {
    mapped[field] = errors[field].map(e => e.message);
  }
  formErrors.value = mapped;
}
</script>

<style scoped>
.titulo-nome {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 32px;
  color: #222;
}
.p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label,
  .p-floatlabel:has(textarea.p-filled) label, .p-floatlabel:has(textarea:focus) label,
  .p-floatlabel:has(.p-dropdown.p-filled) label, .p-floatlabel:has(.p-dropdown:focus) label,
  .p-floatlabel:has(.p-inputnumber.p-filled) label, .p-floatlabel:has(.p-inputnumber:focus) label {
    top: -0.75rem;
    color: var(--color-black);
    font-size: 16px;
  }
  ::v-deep(.p-floatlabel:has(#estado span[aria-expanded="true"])) label {
  color: black !important;
  font-size: 16px !important;
}

  /* Ajuste visual para o Dropdown ficar igual aos outros campos */
  .custom-dropdown .p-dropdown-label {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    min-height: 2.5rem;
    font-size: 1rem;
    background: transparent;
    color: var(--color-black);
  }
  .custom-dropdown .p-dropdown {
    border-radius: 0.75rem;
    border: 1px solid #000;
    background: transparent;
  }

  ::v-deep(.p-inputnumber) {
  background-color: transparent !important;
  border: 1px solid black;
  border-radius: 0.75rem;
  width: 100%;
}

::v-deep(.p-inputnumber input) {
  background-color: transparent !important;
  color: black !important;
  border: none !important;
  box-shadow: none !important;
  outline: none !important;
  width: 100%;
}

::v-deep(.p-inputnumber input::placeholder) {
  color: #666;
}

.custom-dropdown .p-dropdown-label,
.custom-dropdown .p-select-label,
.custom-dropdown .p-dropdown-item,
.custom-dropdown .p-dropdown-items .p-dropdown-item,
span.p-select-label {
  color: #222 !important;
  background: transparent;
}

/* Garante que a opção selecionada também fique preta */
#funcao, #secao {
  color: #222 !important;
}

:deep(.p-select-label) {
  color: #222 !important;
}
</style> 
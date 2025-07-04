<template>
  <h1 class="text-5xl flex justify-center font-bold mt-8 mb-10 text-black">
    Cadastrar usuário
  </h1>

  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="flex justify-center">
    <Form @submit="salvarUsuario" class="flex flex-col gap-6 w-full max-w-lg">
      <!-- Usuário -->
      <FloatLabel>
        <InputText
          id="usuario"
          v-model="usuario"
          name="usuario"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="usuario" class="text-black">Usuário</label>

        <Message v-if="formErrors.usuario" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.usuario[0] }}
        </Message>
      </FloatLabel>

      <!-- Nome -->
      <FloatLabel>
        <InputText
          id="nome"
          v-model="nome"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="nome" class="text-black">Nome</label>

        <Message v-if="formErrors.nome" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.nome[0] }}
        </Message>
      </FloatLabel>

      <!-- Email -->
      <FloatLabel>
        <InputText
          id="email"
          v-model="email"
          type="email"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="email">Email</label>

        <Message v-if="formErrors.email" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.email[0] }}
        </Message>
      </FloatLabel>

      <!-- Telefone -->
      <FloatLabel>
        <InputMask name="serialNumber" mask="(99) 99999-9999"
          id="telefone"
          v-model="telefone"
          type="tel"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />
        
        <label for="telefone">Telefone</label>

        <Message v-if="formErrors.telefone" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.telefone[0] }}
        </Message>
      </FloatLabel>
      
      <div class="flex gap-4">
        <div class="flex-1">
          <!-- Função -->
          <FloatLabel>
            <Select v-model="funcao" :options="funcoes" optionLabel="nome" placeholder="Selecione uma função" class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1" />
          
            <Message v-if="formErrors.funcao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.funcao[0] }}
            </Message>
          </FloatLabel>
        </div>

        <div class="flex-1">
          <!-- Seção -->
          <FloatLabel>
            <Select v-model="secao" :options="secoes" optionLabel="nome" placeholder="Selecione uma seção" class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1" />

            <Message v-if="formErrors.secao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.secao[0] }}
            </Message>
          </FloatLabel>
        </div>
      </div>
      
      <div class="flex justify-center mt-4">
        <Button type="submit" label="Cadastrar" id="btCadastrar" class="w-40">
          <template #icon>
            <svg
              width="23"
              height="16"
              viewBox="0 0 23 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="mr-2"
            >
              <path
                d="M14.5 8C16.71 8 18.5 6.21 18.5 4C18.5 1.79 16.71 0 14.5 0C12.29 0 10.5 1.79 10.5 4C10.5 6.21 12.29 8 14.5 8ZM14.5 2C15.6 2 16.5 2.9 16.5 4C16.5 5.1 15.6 6 14.5 6C13.4 6 12.5 5.1 12.5 4C12.5 2.9 13.4 2 14.5 2ZM14.5 10C11.83 10 6.5 11.34 6.5 14V16H22.5V14C22.5 11.34 17.17 10 14.5 10ZM8.5 14C8.72 13.28 11.81 12 14.5 12C17.2 12 20.3 13.29 20.5 14H8.5ZM5.5 11V8H8.5V6H5.5V3H3.5V6H0.5V8H3.5V11H5.5Z"
                fill="white"
              />
            </svg>
          </template>
        </Button>
      </div>
    </Form>
  </div>
</template>

<script setup lang="ts">
  
  import Loader              from '@/components/Loader.vue';
  import InputText           from 'primevue/inputtext';
  import FloatLabel          from 'primevue/floatlabel';
  import InputMask           from 'primevue/inputmask';
  import Select              from 'primevue/select';
  import Button              from 'primevue/button';
  import axios               from 'axios';
  import { Form }            from '@primevue/forms';
  import { useToast }        from 'primevue/usetoast';
  import { ref, onMounted  } from 'vue';

  const toast      = useToast();

  const usuario    = ref('');
  const nome       = ref('');
  const email      = ref('');
  const telefone   = ref('');
  const funcao     = ref('');
  const funcoes    = ref([]);
  const secao      = ref('');
  const secoes     = ref([]);
  const formErrors = ref<{ [key: string]: string[] }>({});
  const isLoading  = ref(false);

  // Função para setar os erros vindos do backend
  function setErrors(errors: { [key: string]: { message: string }[] }) {
    const mapped: { [key: string]: string[] } = {};

    for (const field in errors) {
      mapped[field] = errors[field].map(e => e.message);
    }

    formErrors.value = mapped;
  }

  onMounted(async () => {
    isLoading.value = true;

    try {
      const [funcoesResp, secoesResp] = await Promise.all([
        axios.get("http://localhost:8000/api/funcao"),
        axios.get("http://localhost:8000/api/secao")
      ]);

      if (funcoesResp.data.success) {

        funcoes.value = funcoesResp.data.funcoes;

      } else {

        toast.add({
          severity: 'error',
          summary : 'Ocorreum um erro ao buscar dados de funções.',
          life    : 3000
        });

      }

      if (secoesResp.data.success) {

        secoes.value = secoesResp.data.secoes;

      } else {

        toast.add({
          severity: 'error',
          summary : 'Ocorreum um erro ao buscar dados de seções.',
          life    : 3000
        });

      }
    } catch (error) {

      toast.add({
        severity: 'error',
        summary : 'Ocorreu um erro ao buscar dadose de funções e seções, por favor recarregue a página e tente novamente.',
        life    : 3000
      });

    } finally {
      isLoading.value = false;
    }
  });

  const salvarUsuario = async () => {
    isLoading.value = true;

    try {
      const data = {
        usuario : usuario.value,
        nome    : nome.value,
        email   : email.value,
        telefone: telefone.value,
        funcao  : funcao.value.id,
        secao   : secao.value.id
      }

      console.log("Dados do usuário:", data);

      await axios.post("http://localhost:8000/api/usuario", data);

      formErrors.value = {};

      toast.add({
        severity: 'success',
        summary : 'Usuário cadastrado com sucesso!',
        life    : 3000
      });
    } catch (error) {
      if (error.response?.status === 422) {

        const backendErrors   = error.response.data.errors;
        const errosFormulario = {};

        for (const field in backendErrors) {
          console.log(field, backendErrors[field]);

          errosFormulario[field] = backendErrors[field].map((msg) => ({
            message: msg
          }));

        }

        setErrors(errosFormulario);
      } else {
        toast.add({
          severity: 'error',
          summary: 'Erro ao cadastrar usuário',
          detail: error.message,
          life: 3000
        });
      }
    } finally {
      isLoading.value = false;
    }
  };


</script>

<style scoped>

  .p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label{
    top: -0.75rem;
    color: var(--color-black);
    font-size: 16px;
  }

  /* span.p-select-label{
    color: var(--color-black)!important;
  } */

  #btCadastrar{
    background-color: var(--btSalvar);
    border-color: var(--btSalvar);
    border-radius: 15px;
    color: var(--color-white);
  }

  /* .p-select-overlay{
    max-height: 100px!important;
    overflow-y: auto!important; 
  } */

</style>
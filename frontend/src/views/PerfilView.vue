<template>
  <h1 class="text-5xl flex justify-center font-bold mt-8 mb-10 text-black">
    Perfil
  </h1>

  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="flex justify-center">
    <Form @submit="salvarUsuario" class="flex flex-col gap-6 w-full max-w-lg">
      <!-- Usuário -->
      <FloatLabel>
        <InputText
          id="usuario"
          v-model="form.usuario"
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
          v-model="form.nome"
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
          v-model="form.email"
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
          v-model="form.telefone"
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
            <Select v-model="form.funcao" :options="funcoes" optionLabel="nome" placeholder="Selecione uma função" class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1" />
          
            <Message v-if="formErrors.id_funcao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.id_funcao[0] }}
            </Message>
          </FloatLabel>
        </div>

        <div class="flex-1">
          <!-- Seção -->
          <FloatLabel>
            <Select v-model="form.secao" :options="secoes" optionLabel="nome" placeholder="Selecione uma seção" class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1" />

            <Message v-if="formErrors.id_secao" severity="error" size="small" variant="simple" class="text-red-600">
              {{ formErrors.id_secao[0] }}
            </Message>
          </FloatLabel>
        </div>
      </div>
      
      <div class="flex justify-center mt-4">
        <Button type="submit" label="Editar" class="w-40 btSalvar rounded-2xl!" icon="pi pi-pencil" />
      </div>
    </Form>
  </div>
</template>

<script setup lang="ts">
  
  import Loader                       from '@/components/Loader.vue';
  import InputText                    from 'primevue/inputtext';
  import FloatLabel                   from 'primevue/floatlabel';
  import InputMask                    from 'primevue/inputmask';
  import Select                       from 'primevue/select';
  import Button                       from 'primevue/button';
  import axios                        from 'axios';
  import { Form }                     from '@primevue/forms';
  import { useToast }                 from 'primevue/usetoast';
  import { ref, onMounted, reactive } from 'vue';

  const toast      = useToast();
  const funcoes    = ref([]);
  const secoes     = ref([]);
  const formErrors = ref<{ [key: string]: string[] }>({});
  const isLoading  = ref(false);

  const form = reactive({
    usuario : '',
    nome    : '',
    email   : '',
    telefone: '',
    funcao  : null as null | { id: number, nome: string },
    secao   : null as null | { id: number, nome: string }
  });

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
        life    : 4000
      });

    } finally {

      isLoading.value = false;
    
    }
  });

  const salvarUsuario = async () => {
    isLoading.value = true;

    try {

      const data = {
        usuario  : form.usuario,
        nome     : form.nome,
        email    : form.email,
        telefone : form.telefone.replace(/\D/g, ''),
        id_funcao: form.funcao ? form.funcao.id : null,
        id_secao : form.secao  ? form.secao.id  : null,
        ativo    : true
      }
      
      await axios.post("http://localhost:8000/api/usuario/:id", data);

      formErrors.value = {};

      limparFormulario();

      toast.add({
        severity: 'success',
        summary : 'Usuário editado com sucesso!',
        life    : 3000
      });

    } catch (error:any) {

      if (error.response?.status === 422) {

        const backendErrors   = error.response.data.errors;
        const errosFormulario: { [key: string]: { message: string }[] } = {};

        for (const field in backendErrors) {

          errosFormulario[field] = backendErrors[field].map((msg: string) => ({
            message: msg
          }));

        }

        setErrors(errosFormulario);

      } else {

        toast.add({
          severity: 'error',
          summary: 'Erro ao editar usuário',
          detail: error.message,
          life: 3000
        });

      }
    } finally {

      isLoading.value = false;
      
    }
  };

  // Função para setar os erros vindos do backend
  function setErrors(errors: { [key: string]: { message: string }[] }) {
    const mapped: { [key: string]: string[] } = {};

    for (const field in errors) {
      mapped[field] = errors[field].map(e => e.message);
    }

    formErrors.value = mapped;
  }

  function limparFormulario(){
    try {

      form.usuario  = "";
      form.nome     = "";
      form.email    = "";
      form.telefone = "";
      form.funcao   = null;
      form.secao    = null;

    } catch (error) {
      
      toast.add({
        severity: 'error',
        summary : 'Ocorreu um erro ao limpar formulário de cadastro.',
        life    : 4000
      });

    }
  }

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

  /* .p-select-overlay{
    max-height: 100px!important;
    overflow-y: auto!important; 
  } */

</style>
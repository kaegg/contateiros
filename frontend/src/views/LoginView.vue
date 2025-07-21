<template>
  <h1 class="text-5xl flex justify-center font-bold mt-8 mb-10 text-black">
    Login
  </h1>

  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="flex justify-center">
    <Form @submit="login" class="flex flex-col gap-6 w-full max-w-lg">
      <!-- Usuário -->
      <FloatLabel>
        <InputText
          id="usuario"
          v-model="form.usuario"
          name="usuario"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="usuario" class="text-black">Nome de Usuário</label>

        <Message v-if="formErrors.usuario" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.usuario[0] }}
        </Message>
      </FloatLabel>

      <!-- Senha -->
      <FloatLabel>
        <InputText
          id="senha"
          v-model="form.senha"
          type="password"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="senha" class="text-black">Senha</label>

        <Message v-if="formErrors.senha" severity="error" size="small" variant="simple" class="text-red-600">
          {{ formErrors.senha[0] }}
        </Message>
      </FloatLabel>
      <div class="flex justify-end mb-2">
        <a @click.prevent="irParaRecuperarSenha" href="#" class="text-green-700 hover:underline text-sm font-medium cursor-pointer">Esqueceu sua senha?</a>
      </div>

      <!-- Email -->
      
      <div class="flex justify-center mt-4">
        <Button type="submit" label="Entrar" class="w-40 btSalvar rounded-2xl!" icon="pi pi-sign-in" />
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
  import { useRouter } from 'vue-router';

  const toast      = useToast();
  const funcoes    = ref([]);
  const secoes     = ref([]);
  const formErrors = ref<{ [key: string]: string[] }>({});
  const isLoading  = ref(false);

  const form = reactive({
    usuario: '',
    nome: '',
    email: '',
    telefone: '',
    funcao: null as null | { id: number, nome: string },
    secao: null as null | { id: number, nome: string },
    senha: ''
  });


  const login = async () => {
    isLoading.value = true;

    try {

      const data = {
        usuario  : form.usuario,
        senha    : form.senha
      }
      
      await axios.post("http://localhost:8000/api/login", data);

      formErrors.value = {};

      limparFormulario();

      toast.add({
        severity: 'success',
        summary : 'Login realizado com sucesso!',
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
          summary: 'Erro ao realizar login',
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
      form.senha    = "";

    } catch (error) {
      
      toast.add({
        severity: 'error',
        summary : 'Ocorreu um erro ao limpar formulário de login.',
        life    : 4000
      });

    }
  }

  const router = useRouter();
  function irParaRecuperarSenha() {
    router.push({ name: 'recuperar-senha' });
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
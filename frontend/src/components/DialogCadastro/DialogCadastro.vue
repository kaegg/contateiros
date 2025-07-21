<template>
  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="card flex justify-center">
    <Dialog
      :visible="visible"
      modal
      :header="titulo || `Criar ${tipo}`"
      @update:visible="emit('update:visible', $event)"
      class="bg-white! text-black!"
    >
      <FormCadastro v-if="props.tipo === 'atividade'"
        @fechar-dialog="emit('update:visible', $event)"
        @criar="criar"
        @criar-fechar="criarFechar"
        :mostrarInputFile="true"
        :sucessoCadastro="sucessoCadastro"
        :form-errors="formErrors"
      />

      <FormCadastro v-else
        @fechar-dialog="emit('update:visible', $event)"
        @criar="criar"
        @criar-fechar="criarFechar"
        :mostrarInputFile="false"
        :sucessoCadastro="sucessoCadastro"
        :formErrors="formErrors"
      />
    </Dialog>
  </div>
</template>

<script setup>
  import { defineProps, defineEmits, ref, watch } from "vue";
  import { useToast }                      from 'primevue/usetoast';
  import Dialog                            from 'primevue/dialog';
  import FormCadastro                      from "./FormCadastro.vue";  
  import axios                             from 'axios';


  const props = defineProps({
    visible: Boolean,
    tipo   : String,
    titulo : { type: String, default: '' }
  });

  // watch(visible, (novaVisibilidade) => {
  //   console.log('Dialog visibilidade alterada:', novaVisibilidade);
  //   // if (!novaVisibilidade) {
  //     formErrors.value = null;
  //     console.log('Dialog fechado, erros do formulário resetados.');
  //   // }  
  // });

  const emit            = defineEmits(['update:visible', 'criar', 'criar-fechar']);
  const sucessoCadastro = ref(false);
  const isLoading       = ref(false);
  const formErrors      = ref(null);
  const toast           = useToast();


  async function criar(dados) {
    isLoading.value = true;

    try {
      const formData = new FormData();
 
      formData.append('codigo', dados.codigo);
      formData.append('nome'  , dados.nome);
      formData.append('ativo', '1');
      
      if (props.tipo === 'atividade') {
        formData.append('icone', dados.icone);


        await axios.post("http://localhost:8000/api/atividade", formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          }
        });
      }else{
        await axios.post("http://localhost:8000/api/instalacao", dados);
      }

      sucessoCadastro.value = true;

      setTimeout(() => {
        sucessoCadastro.value = false;
      }, 100);
    } catch (error) {

      if (error.response && error.response.status === 422) {
        formErrors.value = error.response.data.errors;
      }else{

        toast.add({
          severity: 'error',
          summary: 'Erro ao criar ' + props.tipo,
          detail: error.message,
          life: 3000
        });

      }

    } finally {
      isLoading.value = false;
    }
  }

  async function criarFechar(dados) {
    try {
      await criar(dados);
      emit('update:visible', false);
    } catch (error) {
      console.error('Erro ao criar e fechar:', error);
    }
  }
</script>

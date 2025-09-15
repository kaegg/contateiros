<template>
  <div class="card flex justify-center">
    <Dialog
      :visible="visible"
      modal
      :header="modo === 'edicao' ? 'Edição de Local' : 'Cadastro de Local'"
      @update:visible="emit('update:visible', $event)"
      class="bg-white! text-black!"
    >
      <FormCadastroLocal 
        :modo="modo" 
        :localData="local"
        @fechar-dialog="emit('update:visible', false)" 
      />
    </Dialog>
  </div>
</template>

<script setup>
  import { defineProps, defineEmits } from "vue";
  import Dialog                       from 'primevue/dialog';
  import FormCadastroLocal            from "./FormCadastroLocal.vue";  

  const props = defineProps({
    visible: Boolean,
    modo: {
      type: String,
      default: 'cadastro',
      validator: (value) => ['cadastro', 'edicao'].includes(value)
    },
    local: {
      type: Object,
      default: null
    }
  });

  const emit = defineEmits(['update:visible']);
</script> 
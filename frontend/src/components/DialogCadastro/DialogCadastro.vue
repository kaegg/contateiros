<template>
  <div class="card flex justify-center">
    <Dialog
      :visible="visible"
      modal
      :header="titulo || `Cadastro de ${tipo}`"
      @update:visible="emit('update:visible', $event)"
      class="bg-white! text-black!"
    >
      <FormCadastro v-if="props.tipo === 'atividade'" @fechar-dialog="emit('update:visible', false)" :mostrarInputFile="true" />
      <FormCadastro v-else @fechar-dialog="emit('update:visible', false)" :mostrarInputFile="false" />
    </Dialog>
  </div>
</template>

<script setup>
  import { defineProps, defineEmits } from "vue";
  import Dialog                       from 'primevue/dialog';
  import FormCadastro                 from "./FormCadastro.vue";  

  const props = defineProps({
    visible: Boolean,
    tipo: String,
    titulo: { type: String, default: '' }
  });

  const emit = defineEmits(['update:visible']);
</script>

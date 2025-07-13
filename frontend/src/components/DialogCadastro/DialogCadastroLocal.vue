<template>
  <div class="card flex justify-center">
    <Dialog
      :visible="visible"
      modal
      header="Cadastro de Local"
      @update:visible="emit('update:visible', $event)"
      class="bg-white! text-black!"
    >
      <FormCadastroLocal @fechar-dialog="emit('update:visible', false)" />
    </Dialog>
  </div>
</template>

<script setup>
  import { defineProps, defineEmits } from "vue";
  import Dialog                       from 'primevue/dialog';
  import FormCadastroLocal            from "./FormCadastroLocal.vue";  

  const props = defineProps({
    visible: Boolean
  });

  const emit = defineEmits(['update:visible']);
</script> 
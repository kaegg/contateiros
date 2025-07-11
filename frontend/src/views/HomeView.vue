<template>
  <PesquisarLocal @abrir-dialog="abrirDialog" />
  <FiltroAtividades />

  <DialogCadastro
    :visible="visivelDialog"
    :tipo="tipoCadastro"
    @update:visible="visivelDialog = $event"
  />

  <h1 class="text-black">Home View</h1>
</template>

<script setup>
  import { ref }          from "vue";
  import PesquisarLocal   from '@/components/PesquisarLocal.vue';
  import FiltroAtividades from '@/components/FiltroAtividades.vue';
  import DialogCadastro   from '@/components/DialogCadastro/DialogCadastro.vue';
  
  const visivelDialog = ref(false);
  const tipoCadastro  = ref("atividade");
  
  function abrirDialog(tipo) {
    tipoCadastro.value  = tipo;
    visivelDialog.value = true;
  }
</script>
<template>
  <PesquisarLocal @abrir-dialog="abrirDialog" />
  <DialogCadastro
    v-if="modalCadastroVisivel && tipoCadastro === 'instalacao'"
    :visible="modalCadastroVisivel"
    tipo="instalacao"
    @update:visible="modalCadastroVisivel = $event"
  />
  <DialogCadastro
    v-if="modalCadastroVisivel && tipoCadastro === 'atividade'"
    :visible="modalCadastroVisivel"
    tipo="atividade"
    @update:visible="modalCadastroVisivel = $event"
  />
  <div style="margin-top: 32px;"><InstalacoesTable /></div>
</template>

<script setup>
import PesquisarLocal from '@/components/PesquisarLocal.vue';
import DialogCadastro from '@/components/DialogCadastro/DialogCadastro.vue';
import InstalacoesTable from '@/components/InstalacoesTable.vue';
import { ref } from 'vue';

const modalCadastroVisivel = ref(false);
const tipoCadastro = ref('instalacao');

function abrirDialog(tipo) {
  tipoCadastro.value = tipo;
  modalCadastroVisivel.value = true;
}
</script> 
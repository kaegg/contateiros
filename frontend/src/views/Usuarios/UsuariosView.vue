<template>
  <PesquisarLocal @abrir-dialog="abrirDialog" />
  <DialogCadastro
    v-if="modalCadastroVisivel && tipoCadastro === 'atividade'"
    :visible="modalCadastroVisivel"
    tipo="atividade"
    @update:visible="modalCadastroVisivel = $event"
  />
  <DialogCadastro
    v-if="modalCadastroVisivel && tipoCadastro === 'instalacao'"
    :visible="modalCadastroVisivel"
    tipo="instalacao"
    @update:visible="modalCadastroVisivel = $event"
  />
  <div style="margin-top: 32px;"><UsuariosTable /></div>
</template>

<script setup>
import PesquisarLocal from '@/components/Layout/PesquisarLocal.vue';
import DialogCadastro from '@/components/Dialogs/DialogCadastro/DialogCadastro.vue';
import UsuariosTable  from '@/components/Usuario/UsuariosTable.vue';
import { ref }        from 'vue';

const modalCadastroVisivel = ref(false);
const tipoCadastro = ref('atividade');

function abrirDialog(tipo) {
  tipoCadastro.value = tipo;
  modalCadastroVisivel.value = true;
}
</script> 
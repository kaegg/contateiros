<template>
  <h1 class="text-5xl flex justify-center font-bold mt-8 mb-10 text-black">
    Definir nova senha
  </h1>

  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="flex justify-center">
    <Form @submit="salvarNovaSenha" class="flex flex-col gap-6 w-full max-w-lg">
      <!-- Nova senha -->
      <FloatLabel>
        <InputText
          id="novaSenha"
          v-model="form.novaSenha"
          type="password"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />
        <label for="novaSenha" class="text-black">Nova senha</label>
      </FloatLabel>
      <!-- Confirmação de senha -->
      <FloatLabel>
        <InputText
          id="confirmarSenha"
          v-model="form.confirmarSenha"
          type="password"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />
        <label for="confirmarSenha" class="text-black">Confirme a nova senha</label>
      </FloatLabel>
      <div class="flex justify-center mt-4">
        <Button type="submit" label="Alterar senha" class="w-40 btSalvar rounded-2xl!" icon="pi pi-lock" />
      </div>
    </Form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Form } from '@primevue/forms';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';

const isLoading = ref(false);
const form = reactive({
  novaSenha: '',
  confirmarSenha: ''
});
function salvarNovaSenha() {
  // lógica para salvar nova senha
}
</script>

<style scoped>
.p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label{
  top: -0.75rem;
  color: var(--color-black);
  font-size: 16px;
}
</style> 
<template>
  <h1 class="text-5xl flex justify-center font-bold mt-8 mb-10 text-black">
    Esqueceu sua senha? Não se preocupe!
  </h1>
  <h2 class=" flex justify-center font-bold mt-8 mb-10 text-black">
    Preencha o campo para receber a mudança de senha no seu e-mail 
  </h2>

  <Toast />

  <Loader :isLoading="isLoading" />

  <div class="flex justify-center">
    <Form @submit="recuperarSenha" class="flex flex-col gap-6 w-full max-w-lg">
      <!-- Usuário -->
      <FloatLabel>
        <InputText
          id="email"
          v-model="form.email"
          type="email"
          class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
        />

        <label for="email">Endereço de e-mail</label>
      </FloatLabel>
      
      <div class="flex justify-center mt-4">
        <Button type="submit" label="Enviar e-mail" icon="pi pi-envelope" class="w-40 btSalvar rounded-2xl!" />
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

  const isLoading  = ref(false);

  const form = reactive({
    email: '',
  });

  const recuperarSenha = async () => {
    console.log(form);
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
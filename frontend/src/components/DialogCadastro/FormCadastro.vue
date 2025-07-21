<template>
    <Form class="pt-4">
        <div class="grid grid-cols-2 gap-6">
            <!-- Código -->
            <FloatLabel>
                <InputText
                    id="codigo"
                    v-model="form.codigo"
                    name="codigo"
                    :placeholder="isCampoFocused.codigo ? 'Ex.: ACMPNT-1' : undefined"
                    @focus="isCampoFocused.codigo = true"
                    @blur="isCampoFocused.codigo = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />

                <label for="codigo" class="text-black">Código</label>

                <Message v-if="props.formErrors?.codigo" severity="error" size="small" variant="simple" class="text-red-600" >
                    {{ props.formErrors.codigo[0] }}
                </Message>
            </FloatLabel>

            <!-- Nome -->
            <FloatLabel>
                <InputText
                    id="nome"
                    v-model="form.nome"
                    name="nome"
                    :placeholder="isCampoFocused.nome ? 'Ex.: Acampamento' : undefined"
                    @focus="isCampoFocused.nome = true"
                    @blur="isCampoFocused.nome = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="nome" class="text-black">Nome</label>

                <Message v-if="props.formErrors?.nome" severity="error" size="small" variant="simple" class="text-red-600" >
                    {{ props.formErrors.nome[0] }}
                </Message>
            </FloatLabel>

            <!-- Ícone -->
            <div v-if="props.mostrarInputFile" class="col-span-2 sm:col-span-1">
                <ImportarIcone ref="iconeRef" label="Ícone" @imagem-selecionada="(file) => (form.icone = file)" />
                <Message v-if="props.formErrors?.icone" severity="error" size="small" variant="simple" class="text-red-600" >
                    {{ props.formErrors.icone[0] }}
                </Message>
            </div>
        </div>
        
        <!-- Botoes -->
        <div class="flex justify-start gap-4 mt-8">
            <Button class="btSalvar text-white px-4! py-2! rounded-2xl!" @click.prevent="onCriar">
                <i class="pi pi-save"></i>
                Criar
            </Button>
            <Button class="btSalvar text-white px-4! py-2! rounded-2xl!" @click.prevent="onCriarFechar">
                <i class="pi pi-save"></i>
                Criar e fechar
            </Button>
            <Button class="text-white! border border-red-600! bg-red-600! hover:bg-red-700! hover:border-red-700! px-4! py-2! rounded-2xl!" @click="emit('fechar-dialog')">
                <i class="pi pi-ban"></i>
                Cancelar
            </Button>
        </div>
    </Form>
</template>

<script setup lang="ts">
    import { reactive, defineProps, watch, ref } from 'vue';
    import { Form }                              from '@primevue/forms';
    import InputText                             from 'primevue/inputtext';
    import FloatLabel                            from 'primevue/floatlabel';
    import Button                                from 'primevue/button';
    import ImportarIcone                         from './ImportarIcone.vue';

    const props = withDefaults(defineProps<{
        mostrarInputFile: boolean;
        sucessoCadastro: boolean;
        formErrors: Record<string, string[]> | null;
    }>(), {
        mostrarInputFile: false,
        sucessoCadastro: false,
        formErrors: null
    });

    watch(() => props.sucessoCadastro, (novoValor) => {
        if (novoValor) {
            limparFormulario();
        }
    });

    const emit = defineEmits(['fechar-dialog', 'criar', 'criar-fechar']);

    const iconeRef = ref();

    const form = reactive<{
      codigo: string;
      nome  : string;
      ativo : boolean;
      icone : File | null;
    }>({
      codigo: '',
      nome  : '',
      ativo : true,
      icone : null
    });

    const isCampoFocused = reactive({
        codigo: false,
        nome  : false,
    });

    function onCriar() {
        emit('criar', { ...form });
    }

    function onCriarFechar() {
        emit('criar-fechar', { ...form });
    }

    function limparFormulario() {
        form.codigo = '';
        form.nome = '';
        form.ativo = true;
        form.icone = null;

        iconeRef.value?.removerImagem(); // limpa o preview da imagem
    }
</script>

<style scoped>

  .p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label{
    top: -0.75rem;
    color: var(--color-black);
    font-size: 16px;
  }

</style>

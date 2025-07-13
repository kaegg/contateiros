<template>
    <Form class="pt-4">
        <div class="grid grid-cols-2 gap-6">
            <!-- Nome do Local -->
            <FloatLabel>
                <InputText
                    id="nome"
                    v-model="form.nome"
                    name="nome"
                    :placeholder="isCampoFocused.nome ? 'Ex.: ABC Pvt. Ltd.' : undefined"
                    @focus="isCampoFocused.nome = true"
                    @blur="isCampoFocused.nome = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="nome" class="text-black">Nome do local</label>
            </FloatLabel>

            <!-- Cidade -->
            <FloatLabel>
                <InputText
                    id="cidade"
                    v-model="form.cidade"
                    name="cidade"
                    :placeholder="isCampoFocused.cidade ? 'Ex.: Maringá' : undefined"
                    @focus="isCampoFocused.cidade = true"
                    @blur="isCampoFocused.cidade = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="cidade" class="text-black">Cidade</label>
            </FloatLabel>
        </div>

        <!-- Estado -->
        <div class="w-1/2 mt-8">
            <FloatLabel>
                <Dropdown
                    id="estado"
                    v-model="form.estado"
                    :options="estados"
                    optionLabel="label"
                    optionValue="value"
                    :placeholder="isCampoFocused.estado ? 'Ex.: PR' : undefined"
                    @focus="isCampoFocused.estado = true"
                    @blur="isCampoFocused.estado = false"
                    class="w-full bg-transparent! border! border-black! text-black! rounded-xl! mt-1 mb-1 custom-dropdown"
                    :class="{'p-filled': !!form.estado}"
                />
                <label for="estado" class="text-black">Estado</label>
            </FloatLabel>
        </div>

        <!-- Foto do Local -->
        <div class="mt-8">
            <ImportarIcone label="Fotos do local" />
        </div>

        <!-- Nome do Proprietário -->
        <div class="mt-8">
            <FloatLabel>
                <InputText
                    id="proprietario"
                    v-model="form.proprietario"
                    name="proprietario"
                    :placeholder="isCampoFocused.proprietario ? 'Ex.: Eduardo' : undefined"
                    @focus="isCampoFocused.proprietario = true"
                    @blur="isCampoFocused.proprietario = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="proprietario" class="text-black">Nome do proprietário(a)</label>
            </FloatLabel>
        </div>

        <!-- Número de Celular -->
        <div class="mt-8">
            <FloatLabel>
                <InputText
                    id="celular"
                    v-model="form.celular"
                    name="celular"
                    :placeholder="isCampoFocused.celular ? '+91 | Ex. 44 99999 99999' : undefined"
                    @focus="isCampoFocused.celular = true"
                    @blur="isCampoFocused.celular = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="celular" class="text-black">Número do(a) proprietário(a)</label>
            </FloatLabel>
        </div>

        <!-- Instalações -->
        <div class="mt-8">
            Instalações
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-2">
                <div 
                    v-for="instalacao in instalacoes" 
                    :key="instalacao"
                    @click="toggleInstalacao(instalacao)"
                    :class="[
                        'px-3 py-2 text-sm font-medium cursor-pointer transition-all duration-200 text-center',
                        'rounded-full',
                        form.instalacoes.includes(instalacao)
                            ? 'border-2 border-[#3E9957] bg-[#3E9957] text-white'
                            : 'border-2 border-gray-300 bg-white text-gray-700 hover:border-gray-400'
                    ]"
                    style="min-width: 0;"
                >
                    {{ instalacao }}
                </div>
            </div>
        </div>

        <!-- Atividades -->
        <div class="mt-8">
            Atividades
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mt-2">
                <div 
                    v-for="atividade in atividades" 
                    :key="atividade"
                    @click="toggleAtividade(atividade)"
                    :class="[
                        'px-3 py-2 text-sm font-medium cursor-pointer transition-all duration-200 text-center',
                        'rounded-full',
                        form.atividades.includes(atividade)
                            ? 'border-2 border-[#3E9957] bg-[#3E9957] text-white'
                            : 'border-2 border-gray-300 bg-white text-gray-700 hover:border-gray-400'
                    ]"
                    style="min-width: 0;"
                >
                    {{ atividade }}
                </div>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mt-8">
            <FloatLabel>
                <Textarea
                    id="descricao"
                    v-model="form.descricao"
                    name="descricao"
                    :placeholder="isCampoFocused.descricao ? 'Ex. Aqui é um ótimo lugar para...' : undefined"
                    @focus="isCampoFocused.descricao = true"
                    @blur="isCampoFocused.descricao = false"
                    rows="4"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="descricao" class="text-black">Descrição</label>
            </FloatLabel>
        </div>

        <!-- Botões -->
        <div class="flex justify-start gap-4 mt-8">
            <Button class="btSalvar text-white px-4! py-2! rounded-2xl!" @click="criarLocal">
                <i class="pi pi-save"></i>
                Criar
            </Button>
            <Button class="text-white! border border-red-600! bg-red-600! hover:bg-red-700! hover:border-red-700! px-4! py-2! rounded-2xl!" @click="emit('fechar-dialog')">
                <i class="pi pi-ban"></i>
                Cancelar
            </Button>
        </div>
    </Form>
</template>

<script setup lang="ts">
    import { reactive } from 'vue';
    import { Form }                  from '@primevue/forms';
    import InputText                 from 'primevue/inputtext';
    import Textarea                  from 'primevue/textarea';
    import FloatLabel                from 'primevue/floatlabel';
    import Button                    from 'primevue/button';
    import ImportarIcone             from './ImportarIcone.vue';
    import Dropdown                  from 'primevue/dropdown';

    const emit = defineEmits(['fechar-dialog']);

    const form = reactive({
        nome: '',
        cidade: '',
        estado: '',
        proprietario: '',
        celular: '',
        foto: null,
        instalacoes: [] as string[],
        atividades: [] as string[],
        descricao: ''
    });

    const isCampoFocused = reactive({
        nome: false,
        cidade: false,
        estado: false,
        proprietario: false,
        celular: false,
        descricao: false
    });

    const instalacoes = ['Banheiro', 'Energia', 'Internet', 'Rede Celular'];
    const atividades = ['Jornada', 'Acampamento', 'Day Use', 'Trilhas', 'Eventos'];
    const estados = [
        { label: 'AC', value: 'AC' }, { label: 'AL', value: 'AL' }, { label: 'AP', value: 'AP' }, { label: 'AM', value: 'AM' },
        { label: 'BA', value: 'BA' }, { label: 'CE', value: 'CE' }, { label: 'DF', value: 'DF' }, { label: 'ES', value: 'ES' },
        { label: 'GO', value: 'GO' }, { label: 'MA', value: 'MA' }, { label: 'MT', value: 'MT' }, { label: 'MS', value: 'MS' },
        { label: 'MG', value: 'MG' }, { label: 'PA', value: 'PA' }, { label: 'PB', value: 'PB' }, { label: 'PR', value: 'PR' },
        { label: 'PE', value: 'PE' }, { label: 'PI', value: 'PI' }, { label: 'RJ', value: 'RJ' }, { label: 'RN', value: 'RN' },
        { label: 'RS', value: 'RS' }, { label: 'RO', value: 'RO' }, { label: 'RR', value: 'RR' }, { label: 'SC', value: 'SC' },
        { label: 'SP', value: 'SP' }, { label: 'SE', value: 'SE' }, { label: 'TO', value: 'TO' }
    ];

    function toggleInstalacao(instalacao: string) {
        const index = form.instalacoes.indexOf(instalacao);
        if (index > -1) {
            form.instalacoes.splice(index, 1);
        } else {
            form.instalacoes.push(instalacao);
        }
    }

    function toggleAtividade(atividade: string) {
        const index = form.atividades.indexOf(atividade);
        if (index > -1) {
            form.atividades.splice(index, 1);
        } else {
            form.atividades.push(atividade);
        }
    }

    function criarLocal() {
        // Aqui você pode implementar a lógica para salvar o local
        console.log('Dados do local:', form);
        // Por enquanto apenas fecha o modal
        emit('fechar-dialog');
    }
</script>

<style scoped>

  .p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label,
  .p-floatlabel:has(textarea.p-filled) label, .p-floatlabel:has(textarea:focus) label,
  .p-floatlabel:has(.p-dropdown.p-filled) label, .p-floatlabel:has(.p-dropdown:focus) label {
    top: -0.75rem;
    color: var(--color-black);
    font-size: 16px;
  }

  /* Ajuste visual para o Dropdown ficar igual aos outros campos */
  .custom-dropdown .p-dropdown-label {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    min-height: 2.5rem;
    font-size: 1rem;
    background: transparent;
    color: var(--color-black);
  }
  .custom-dropdown .p-dropdown {
    border-radius: 0.75rem;
    border: 1px solid #000;
    background: transparent;
  }

</style>
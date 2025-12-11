<template>
    <Toast />
    <Loader :isLoading="isLoadingData" />
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
            <ImportarIcone label="Fotos do local" @imagem-selecionada="onImagemSelecionada" />
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
                <InputMask
                    name="celular"
                    mask="(99) 99999-9999"
                    id="celular"
                    :placeholder="isCampoFocused.celular ? 'Ex. 44 99999 99999' : undefined"
                    v-model="form.celular"
                    type="tel"
                    @focus="isCampoFocused.celular = true"
                    @blur="isCampoFocused.celular = false"
                    class="bg-transparent! border! border-black! text-black! rounded-xl! w-full! mt-1 mb-1"
                />
                <label for="celular" class="text-black">Número do(a) proprietário(a)</label>
            </FloatLabel>
        </div>

        <!-- Capacidade Estimada -->
        <div class="mt-8">
            <FloatLabel>
                <InputNumber
                    id="capacidade"
                    v-model="form.capacidade"
                    name="capacidade"
                    :placeholder="isCampoFocused.capacidade ? 'Ex.: 50' : undefined"
                    @focus="isCampoFocused.capacidade = true"
                    @blur="isCampoFocused.capacidade = false"
                    :min="1"
                    :max="10000"
                    class="w-full mt-1 mb-1"
                />
                <label for="capacidade" class="text-black">Capacidade estimada (pessoas)</label>
            </FloatLabel>
        </div>

        <!-- Instalações -->
        <div class="mt-8">
            Instalações
            <div v-if="instalacoes.length === 0" class="text-gray-500 text-sm mt-2">
                Carregando instalações disponíveis...
            </div>
            <div v-else class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-2">
                <div 
                    v-for="instalacao in instalacoes" 
                    :key="instalacao.id"
                    @click="toggleInstalacao(instalacao.id)"
                    :class="[
                        'px-3 py-2 text-sm font-medium cursor-pointer transition-all duration-200 text-center',
                        'rounded-full',
                        form.instalacoes.includes(instalacao.id)
                            ? 'border-2 border-[#3E9957] bg-[#3E9957] text-white'
                            : 'border-2 border-gray-300 bg-white text-gray-700 hover:border-gray-400'
                    ]"
                    style="min-width: 0;"
                >
                    {{ instalacao.nome }}
                </div>
            </div>
        </div>

        <!-- Atividades -->
        <div class="mt-8">
            Atividades
            <div v-if="atividades.length === 0" class="text-gray-500 text-sm mt-2">
                Carregando atividades disponíveis...
            </div>
            <div v-else class="grid grid-cols-2 sm:grid-cols-5 gap-3 mt-2">
                <div 
                    v-for="atividade in atividades" 
                    :key="atividade.id"
                    @click="toggleAtividade(atividade.id)"
                    :class="[
                        'px-3 py-2 text-sm font-medium cursor-pointer transition-all duration-200 text-center',
                        'rounded-full',
                        form.atividades.includes(atividade.id)
                            ? 'border-2 border-[#3E9957] bg-[#3E9957] text-white'
                            : 'border-2 border-gray-300 bg-white text-gray-700 hover:border-gray-400'
                    ]"
                    style="min-width: 0;"
                >
                    {{ atividade.nome }}
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
        <div class="flex gap-4 justify-end mt-8">
            <Button 
                class="text-white! border border-green-600! bg-green-600! hover:bg-green-700! hover:border-green-700! px-4! py-2! rounded-2xl!" 
                @click="criarLocal"
                :disabled="loading"
            >
                <i v-if="loading" class="pi pi-spinner pi-spin mr-2"></i>
                <i v-else class="pi pi-save"></i>
                {{ loading ? (isEditMode ? 'Atualizando...' : 'Criando...') : (isEditMode ? 'Atualizar' : 'Criar') }}
            </Button>
            <Button 
                class="text-white! border border-red-600! bg-red-600! hover:bg-red-700! hover:border-red-700! px-4! py-2! rounded-2xl!" 
                @click="emit('fechar-dialog')"
                :disabled="loading"
            >
                <i class="pi pi-ban"></i>
                Cancelar
            </Button>
        </div>
    </Form>
</template>

<script setup lang="ts">
import { reactive, onMounted, ref, watch, computed } from 'vue';
import { localService, activityService, facilityService } from '@/services/api.js';
import { localImageService } from '@/services/localImageService.js';
import { useAuthStore } from '@/stores/authStore';
import { Form }                  from '@primevue/forms';
import InputText                 from 'primevue/inputtext';
import InputNumber               from 'primevue/inputnumber';
import Textarea                  from 'primevue/textarea';
import FloatLabel                from 'primevue/floatlabel';
import Button                    from 'primevue/button';
import Toast                     from 'primevue/toast';
import ImportarIcone             from '@/components/Dialogs/DialogCadastro/ImportarIcone.vue';
import Dropdown                  from 'primevue/dropdown';
import InputMask                 from 'primevue/inputmask';
import { useToast }              from 'primevue/usetoast';
import Loader                    from '@/components/Layout/Loader.vue';

// Props para modo de edição
const props = defineProps<{
  modo?: 'cadastro' | 'edicao';
  localData?: any; // Dados do local para edição
}>();

const emit = defineEmits(['fechar-dialog']);

const toast = useToast();
const authStore = useAuthStore();
const loading = ref(false);
const isLoadingData = ref(true);
const isEditMode = computed(() => props.modo === 'edicao');

const form = reactive({
    nome: '',
    cidade: '',
    estado: '',
    proprietario: '',
    celular: '',
    capacidade: null as number | null,
    foto: null as string | null,
    instalacoes: [] as number[],
    atividades: [] as number[],
    descricao: ''
});

const isCampoFocused = reactive({
    nome: false,
    cidade: false,
    estado: false,
    proprietario: false,
    celular: false,
    capacidade: false,
    descricao: false
});

// Arrays para armazenar as opções do backend
const instalacoes = reactive([] as any[]);
const atividades = reactive([] as any[]);

const estados = [
    { label: 'AC', value: 'AC' }, { label: 'AL', value: 'AL' }, { label: 'AP', value: 'AP' }, { label: 'AM', value: 'AM' },
    { label: 'BA', value: 'BA' }, { label: 'CE', value: 'CE' }, { label: 'DF', value: 'DF' }, { label: 'ES', value: 'ES' },
    { label: 'GO', value: 'GO' }, { label: 'MA', value: 'MA' }, { label: 'MT', value: 'MT' }, { label: 'MS', value: 'MS' },
    { label: 'MG', value: 'MG' }, { label: 'PA', value: 'PA' }, { label: 'PB', value: 'PB' }, { label: 'PR', value: 'PR' },
    { label: 'PE', value: 'PE' }, { label: 'PI', value: 'PI' }, { label: 'RJ', value: 'RJ' }, { label: 'RN', value: 'RN' },
    { label: 'RS', value: 'RS' }, { label: 'RO', value: 'RO' }, { label: 'RR', value: 'RR' }, { label: 'SC', value: 'SC' },
    { label: 'SP', value: 'SP' }, { label: 'SE', value: 'SE' }, { label: 'TO', value: 'TO' }
];

// Carregar dados do backend
onMounted(async () => {
    isLoadingData.value = true;
    try {
        console.log('Carregando dados do backend...');
        
        // Carregar atividades
        const atividadesResponse = await activityService.getAll();
        console.log('Resposta atividades:', atividadesResponse);
        if (atividadesResponse.success) {
            atividades.push(...atividadesResponse.atividades);
            console.log('Atividades carregadas:', atividades);
        } else {
            console.error('Erro ao carregar atividades:', atividadesResponse.message);
        }

        // Carregar instalações
        const instalacoesResponse = await facilityService.getAll();
        console.log('Resposta instalações:', instalacoesResponse);
        if (instalacoesResponse.success) {
            instalacoes.push(...instalacoesResponse.instalacoes);
            console.log('Instalações carregadas:', instalacoes);
        } else {
            console.error('Erro ao carregar instalações:', instalacoesResponse.message);
        }

        // Se estiver em modo de edição, carregar dados do local
        if (isEditMode.value && props.localData) {
            carregarDadosLocal(props.localData);
        }
    } catch (error) {
        console.error('Erro ao carregar dados:', error);
    } finally {
        isLoadingData.value = false;
    }
});

// Função para carregar dados do local em modo de edição
function carregarDadosLocal(localData: any) {
    console.log('Carregando dados do local para edição:', localData);
    
    form.nome = localData.nome || '';
    form.cidade = localData.cidade || '';
    form.estado = localData.estado || '';
    form.proprietario = localData.nome_proprietario || '';
    form.celular = localData.telefone_proprietario || '';
    form.capacidade = localData.capacidade_pessoas || null;
    form.descricao = localData.descricao || '';
    
    // Carregar atividades e instalações associadas
    if (localData.atividades) {
        form.atividades = localData.atividades.map((atividade: any) => atividade.id);
    }
    
    if (localData.instalacoes) {
        form.instalacoes = localData.instalacoes.map((instalacao: any) => instalacao.id);
    }
}

// Handler do evento de imagem do ImportarIcone
const onImagemSelecionada = (file: File | null) => {
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            form.foto = e.target?.result as string; // Base64 da imagem
        };
        reader.readAsDataURL(file);
    } else {
        form.foto = null;
    }
};

function toggleInstalacao(instalacaoId: number) {
    const index = form.instalacoes.indexOf(instalacaoId);
    if (index > -1) {
        form.instalacoes.splice(index, 1);
    } else {
        form.instalacoes.push(instalacaoId);
    }
}

function toggleAtividade(atividadeId: number) {
    const index = form.atividades.indexOf(atividadeId);
    if (index > -1) {
        form.atividades.splice(index, 1);
    } else {
        form.atividades.push(atividadeId);
    }
}

async function criarLocal() {
    if (!form.nome || !form.cidade || !form.estado || !form.proprietario || !form.celular || !form.capacidade) {
        toast.add({
            severity: 'error',
            summary: 'Campos obrigatórios',
            detail: 'Por favor, preencha todos os campos obrigatórios.',
            life: 3000
        });
        return;
    }

    loading.value = true;

    try {
        const dadosLocal: any = {
            nome: form.nome,
            cidade: form.cidade,
            estado: form.estado,
            nome_proprietario: form.proprietario,
            telefone_proprietario: form.celular,
            capacidade_pessoas: form.capacidade,
            id_usuario_criacao: authStore.user?.id,
            id_usuario_alteracao: authStore.user?.id,
            ativo: true
        };

        // Adicionar descrição se fornecida
        if (form.descricao) {
            dadosLocal.descricao = form.descricao;
        }

        // Adicionar atividades e instalações se selecionadas
        if (form.atividades.length > 0) {
            dadosLocal.atividades = form.atividades;
        }
        if (form.instalacoes.length > 0) {
            dadosLocal.instalacoes = form.instalacoes;
        }

        let localResponse;
        
        if (isEditMode.value && props.localData) {
            // Modo de edição
            console.log('Atualizando local:', dadosLocal);
            localResponse = await localService.update(props.localData.id, dadosLocal);
            
            if (localResponse.success) {
                toast.add({
                    severity: 'success',
                    summary: 'Local atualizado com sucesso!',
                    life: 3000
                });
            }
        } else {
            // Modo de criação
            console.log('Criando local:', dadosLocal);
            localResponse = await localService.create(dadosLocal);
            
            if (localResponse.success) {
                // Se houver imagem, envia para o endpoint de imagem
                if (form.foto && localResponse?.local?.id) {
                    try {
                        await localImageService.addImage(localResponse.local.id, form.foto);
                        console.log('Imagem enviada com sucesso!');
                    } catch (imgError) {
                        console.error('Erro ao enviar imagem:', imgError);
                    }
                }
                
                toast.add({
                    severity: 'success',
                    summary: 'Local criado com sucesso!',
                    life: 3000
                });
            }
        }
        
      window.location.reload();
        
    } catch (error: any) {
        console.error('Erro ao salvar local:', error);
        
        toast.add({
            severity: 'error',
            summary: 'Erro ao salvar local',
            detail: error.response?.message || error.message || 'Erro desconhecido',
            life: 3000
        });
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
  .p-floatlabel:has(input.p-filled) label, .p-floatlabel:has(input:focus) label,
  .p-floatlabel:has(textarea.p-filled) label, .p-floatlabel:has(textarea:focus) label,
  .p-floatlabel:has(.p-dropdown.p-filled) label, .p-floatlabel:has(.p-dropdown:focus) label,
  .p-floatlabel:has(.p-inputnumber.p-filled) label, .p-floatlabel:has(.p-inputnumber:focus) label {
    top: -0.75rem;
    color: var(--color-black);
    font-size: 16px;
  }
  ::v-deep(.p-floatlabel:has(#estado span[aria-expanded="true"])) label {
  color: black !important;
  font-size: 16px !important;
}

  /* Ajuste visual para o Dropdown ficar igual aos outros campos */
  .custom-dropdown .p-dropdown-label {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    min-height: 2.5rem;
    font-size: 1rem;
    background: transparent;
    color: black !important;
  }
  .custom-dropdown .p-dropdown {
    border-radius: 0.75rem;
    border: 1px solid #000;
    background: transparent;
  }
  ::v-deep(.p-select-label){
    color: black !important;
  }

  ::v-deep(.p-inputnumber) {
  background-color: transparent !important;
  border: 1px solid black;
  border-radius: 0.75rem;
  width: 100%;
}

::v-deep(.p-inputnumber input) {
  background-color: transparent !important;
  color: black !important;
  border: none !important;
  box-shadow: none !important;
  outline: none !important;
  width: 100%;
}

  ::v-deep(.p-inputnumber input::placeholder) {
    color: #666;
  }

  /* Placeholder do dropdown */
  ::v-deep(.p-dropdown-label.p-placeholder) {
    color: #666 !important;
  }
  
  ::v-deep(.p-dropdown .p-dropdown-label.p-placeholder) {
    color: #666 !important;
  }
</style>
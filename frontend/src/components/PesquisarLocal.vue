<template>
    <Menubar class="bg-white! rounded-none!" id="pesquisarLocal">
        <template #start>
            <Select v-model="opcaoBusca" :options="opcoesBusca" optionLabel="name" optionValue="value" class="rounded-2xl! w-35 ml-3 btSalvar" id="selectBusca" />

            <InputGroup class="w-5xl! ml-10">
                <IconField class="my-4">
                    <InputIcon class="pi pi-map-marker" id="inputIcon" />
                    <InputText id="inputPesquisar" placeholder="Pesquisar local" type="text" class="rounded-l-2xl!" />
                    
                    <InputGroupAddon class="rounded-r-2xl! botaoPesquisar">
                        <Button icon="pi pi-search" class="rounded-r-2xl botaoPesquisar" />
                    </InputGroupAddon>
                </IconField>
            </InputGroup>
        </template>
        <template #end>
            <InputGroup>
                <Button label="Adicionar local" id="btCadastrarLocal" class="rounded-l-2xl! w-40 btSalvar" @click="abrirModalLocal">
                  <template #icon>
                    <svg width="19" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 0V3H19V5H16V8H14V5H11V3H14V0H16ZM8 12C6.9 12 6 11.1 6 10C6 8.9 6.9 8 8 8C9.1 8 10 8.9 10 10C10 11.1 9.1 12 8 12ZM9 2.06V4.08C8.66921 4.02773 8.33489 4.00098 8 4C4.65 4 2 6.57 2 10.2C2 12.54 3.95 15.64 8 19.34C12.05 15.64 14 12.55 14 10.2V10H16V10.2C16 13.52 13.33 17.45 8 22C2.67 17.45 0 13.52 0 10.2C0 5.22 3.8 2 8 2C8.34 2 8.67 2.02 9 2.06Z" fill="white"/>
                    </svg>
                  </template>
                </Button>

                <InputGroupAddon class="rounded-r-2xl! btSalvar">
                    <Button icon="pi pi-angle-down" class="rounded-r-2xl! btSalvar" @click="toggle"/>
                    <!-- Menu de opções de cadastro -->
                    <Menu
                      ref="menuCadastro"
                      :model="opcoesCadastro"
                      popup
                    />
                </InputGroupAddon>
            </InputGroup>
        </template>
    </Menubar>

    <!-- Modal de Cadastro de Local -->
    <DialogCadastroLocal
      :visible="modalLocalVisivel"
      @update:visible="modalLocalVisivel = $event"
    />
</template>

<script setup lang="ts">
    import { ref, defineEmits } from "vue";
    import { useRouter }   from "vue-router";
    import Menubar         from 'primevue/menubar';
    import Select          from 'primevue/select';
    import InputText       from 'primevue/inputtext';
    import IconField       from 'primevue/iconfield';
    import InputIcon       from 'primevue/inputicon';
    import InputGroup      from 'primevue/inputgroup';
    import InputGroupAddon from 'primevue/inputgroupaddon';
    import Button          from 'primevue/button';
    import Menu            from 'primevue/menu';
    import DialogCadastroLocal from './DialogCadastro/DialogCadastroLocal.vue';

    const opcaoBusca  = ref("Todos");    
    const opcoesBusca = ref([
        { name: 'Todos' , value: 'Todos'  },
        { name: 'Nome'  , value: 'nome'   },
        { name: 'Cidade', value: 'cidade' },
    ]);

    const router = useRouter();

    const menuCadastro   = ref();
    const modalLocalVisivel = ref(false);
    const emit = defineEmits(['abrir-dialog']);

    const opcoesCadastro = ref([
        {
            label: 'Cadastrar atividade',
            command: () => {
                emit('abrir-dialog', 'atividade');
            }
        },
        {
            label: 'Cadastrar instalação',
            command: () => {
                emit('abrir-dialog', 'instalação');
            }
        },
        {
            label: 'Cadastrar usuário',
            command: () => {
                router.push({ name: 'cadastroUsuario' });
            }
        }
    ]);

    const toggle = (event: any) => {
        menuCadastro.value.toggle(event);
    };

    const abrirModalLocal = () => {
        modalLocalVisivel.value = true;
    };
</script>

<style scoped>
    #pesquisarLocal{
        border: none;
        border-bottom: 1px solid #C1C7CD;
    }

    #selectBusca{
        background-color: var(--btSalvar);
        border-color: var(--btSalvar);
    }

    ::v-deep(.p-select-dropdown-icon){
        color: #fff!important;
    }

    #inputPesquisar{
        background-color: #F2F4F8;
        border-color    : #C1C7CD;
    }

    .botaoPesquisar{
        margin-left     : -4px;
        background-color: #D9D9D9!important;
        border-color    : #C1C7CD!important;
        color           : var(--color-black);
        z-index         : 100;
    }

    #inputIcon, #inputPesquisar{
        color: #969696;
    }

    #btCadastrarLocal{
        background-color: var(--btSalvar);
        border-color: var(--btSalvar);
        /* border-radius: 15px; */
        color: var(--color-white);
    }

    .btCadastros{
        background-color: var(--btSalvar);
        border-color    : var(--btSalvar);
    }

    .p-button:not(:disabled):hover{
        background-color: #2e7040;
        border-color    : var(--btSalvar);
    }

    ::v-deep(.pi-angle-down){
        color:#fff;
    }
</style>
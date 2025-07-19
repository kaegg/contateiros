<template>
  <PesquisarLocal @abrir-dialog="abrirDialog" />
  <FiltroAtividades />

  <DialogCadastro
    :visible="visivelDialog"
    :tipo="tipoCadastro"
    @update:visible="visivelDialog = $event"
  />

  <div style="display: flex; flex-wrap: wrap; gap: 24px; margin: 32px auto; max-width: 1400px; padding: 0 24px; justify-content: center;">
    <LocalCard
      id="1"
      :activities="[
        { name: 'Jornada', icon: JornadaIcon },
        { name: 'Acampamento', icon: AcampamentoIcon },
        { name: 'Day Use', icon: DayUseIcon }
      ]"
      title="Travessia Poços de Caldas"
      city="Águas da Prata"
      state="MG"
      :rating="3"
      owner="Henrique Hiroshi Maeda"
      phone="(44) 98800-5555"
      :capacity="100"
      :facilities="['Banheiro', 'Energia', 'Internet', 'Rede Celular']"
      image="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80"
      @ver-detalhes="abrirDetalhes"
    />
    <LocalCard
      id="2"
      :activities="[
        { name: 'Jornada', icon: JornadaIcon },
        { name: 'Acampamento', icon: AcampamentoIcon }
      ]"
      title="Travessia Lapinha Tabueiros"
      city="Riacho Fundo"
      state="MG"
      :rating="4"
      owner="Leonardo Almenara"
      phone="(44) 98800-5989"
      :capacity="120"
      :facilities="['Banheiro', 'Energia', 'Internet', 'Rede Celular']"
      image="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80"
      @ver-detalhes="abrirDetalhes"
    />
    <LocalCard
      id="3"
      :activities="[
        { name: 'Jornada', icon: JornadaIcon },
        { name: 'Day Use', icon: DayUseIcon }
      ]"
      title="Circuito Inter Parques Curitiba"
      city="Curitiba"
      state="PR"
      :rating="5"
      owner="Kauan Eguchi"
      phone="(44) 98890-5555"
      :capacity="50"
      :facilities="['Banheiro', 'Energia', 'Internet', 'Rede Celular']"
      image="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80"
      @ver-detalhes="abrirDetalhes"
    />
    <LocalCard
      id="4"
      :activities="[
        { name: 'Acampamento', icon: AcampamentoIcon },
        { name: 'Day Use', icon: DayUseIcon }
      ]"
      title="Parque do Ingá"
      city="Maringá"
      state="PR"
      :rating="4"
      owner="Raphael Ichiro"
      phone="(44) 98801-8555"
      :capacity="100"
      :facilities="['Banheiro', 'Energia', 'Internet', 'Rede Celular']"
      image="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80"
      @ver-detalhes="abrirDetalhes"
    />
  </div>

  <div v-if="detalhesVisiveis" class="modal-overlay" @click.self="fecharDetalhes">
    <div class="modal-content">
      <LocalInfo
        v-bind="localSelecionado"
        @edit="onEditLocal"
        @delete="onDeleteLocal"
      />
      <button class="modal-close" @click="fecharDetalhes">Fechar</button>
    </div>
  </div>

  <h1 class="text-black">Home View</h1>
</template>

<script setup>
  import { ref }          from "vue";
  import PesquisarLocal   from '@/components/PesquisarLocal.vue';
  import FiltroAtividades from '@/components/FiltroAtividades.vue';
  import DialogCadastro   from '@/components/DialogCadastro/DialogCadastro.vue';
  import LocalCard        from '@/components/LocalCard.vue';
  import LocalInfo        from '@/components/LocalInfo.vue';

  // Ícones SVG como string
  const JornadaIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>`;
  const AcampamentoIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 20L10 4M5 20l7-12 7 12z"/></svg>`;
  const DayUseIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#388e3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>`;

  const visivelDialog = ref(false);
  const tipoCadastro  = ref("atividade");
  function abrirDialog(tipo) {
    tipoCadastro.value  = tipo;
    visivelDialog.value = true;
  }

  // Modal de detalhes do local
  const detalhesVisiveis = ref(false);
  const localSelecionado = ref({});

  function abrirDetalhes(local) {
    localSelecionado.value = local;
    detalhesVisiveis.value = true;
  }
  function fecharDetalhes() {
    detalhesVisiveis.value = false;
    localSelecionado.value = {};
  }
  function onEditLocal() {
    // lógica para editar local
    alert('Editar local!');
  }
  function onDeleteLocal() {
    // lógica para deletar local
    alert('Excluir local!');
  }
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-content {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  min-width: 350px;
  max-width: 90vw;
  box-shadow: 0 4px 24px rgba(0,0,0,0.12);
  position: relative;
}
.modal-close {
  position: absolute;
  top: 12px;
  right: 12px;
  background: #e74c3c;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  font-size: 1.2rem;
  cursor: pointer;
}
</style>
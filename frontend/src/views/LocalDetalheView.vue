<template>
  <div class="local-detalhe-prototipo">
    <PesquisarLocal @abrir-dialog="abrirDialog" />
    
    <DialogCadastroLocal
      :visible="visivelDialogEdicao"
      modo="edicao"
      @update:visible="visivelDialogEdicao = $event"
    />

    <div v-if="modalConfirmarExclusao" class="modal-overlay">
      <div class="modal-confirm">
        <div class="modal-header">
          <span>Inativar Local</span>
          <button class="modal-close" @click="modalConfirmarExclusao = false">✕</button>
        </div>
        <div class="modal-body">
          Tem certeza que quer inativar o local '{{ local.nome }}' 
        </div>
        <div class="modal-actions">
          <button class="btn-sim" @click="confirmarExclusao">Sim</button>
          <button class="btn-cancelar" @click="modalConfirmarExclusao = false">Cancelar</button>
        </div>
      </div>
    </div>

    <div class="local-detalhe-header">
      <div>
        <h1 class="local-title">
          Travessia Poços de Caldas
          <span class="stars">
            <span v-for="i in 5" :key="i" :class="['star', { filled: i <= 4 }]">★</span>
          </span>
        </h1>
        <div class="local-subtitle">MG - Águas da Prata</div>
        <button class="avaliar-btn" @click="scrollToComentario">Avaliar</button>
      </div>
    </div>
    <div class="local-detalhe-main">
      <div class="mapa-embed">
        <iframe
          class="local-mapa-iframe"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3689.234073289889!2d-46.71916768488544!3d-21.93472248551945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c9c7e2e2e2e2e2%3A0x2e2e2e2e2e2e2e2e!2s%C3%81guas%20da%20Prata%2C%20SP!5e0!3m2!1spt-BR!2sbr!4v1680000000000!5m2!1spt-BR!2sbr"
          width="100%"
          height="320"
          style="border:0; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.10); background: #eaeaea;"
          allowfullscreen
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
      <div class="local-detalhe-info">
        <LocalInfo
          :ownerName="local.owner"
          :ownerPhone="local.phone"
          :capacity="local.capacity"
          :facilities="local.facilities"
          :activities="local.activities"
          :creator="local.creator"
          @edit="onEditLocal"
          @delete="onDeleteLocal"
        />
      </div>
    </div>
    <div class="local-detalhe-fotos">
      <div class="fotos-grid">
        <img v-for="(foto, idx) in local.fotos" :key="idx" :src="foto" class="foto" />
      </div>
    </div>

    <div class="local-detalhe-descricao">
      <h2>Descrição</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ullamcorper elit massa, et molestie est dictum quis. Ut tellus ex, blandit nec cursus sit amet, blandit eget nunc. Mauris suscipit fermentum dolor, at vulputate libero aliquam vel. Proin laoreet ligula id urna congue commodo. Aenean ullamcorper maximus aliquet. Donec et neque luctus, mattis lorem vel, cursus purus. Mauris facilisis ex id purus hendrerit, at lacinia leo semper. Sed ullamcorper augue ac nunc dictum commodo. Aenean suscipit ultricies lacus, quis varius lectus dignissim et.
      </p>
      <p>
        Aenean volutpat ligula nec ornare sagittis. Morbi fermentum ante ut ligula auctor, in posuere nisi scelerisque. Quisque ultricies luctus dapibus. Nullam sit amet arcu nec nulla blandit interdum sit amet vel erat. Nulla leo leo. Vestibulum blandit consequat orci, ut aliquam libero luctus sed. Vivamus suscipit ex at sem dignissim, sed pretium sem hendrerit. Morbi atid elit, ornare id nisl a, commodo vestibulum dui. Etiam quis eros aliquet, fringilla felis et, molestie augue. In ut lacinia tortor. Nullam ullamcorper, mi at placerat porttitor, felis odio congue elit, et iaculis nisi ex vel diam. Cras venenatis maximus tellus et auctor. Fusce gravida neque sit amet leo malesuada ultricies.
      </p>
    </div>

    <div class="local-detalhe-comentarios">
      <div class="comentarios-lista">
        <div v-for="comentario in comentarios" :key="comentario.id" class="comentario-item">
          <div class="comentario-nome">{{ comentario.nome }}</div>
          <div class="comentario-estrelas">
            <span v-for="i in 5" :key="i" :class="['star', { filled: i <= comentario.estrelas }]">★</span>
          </div>
          <div class="comentario-texto">{{ comentario.texto }}</div>
        </div>
      </div>
      <div class="comentario-novo" id="comentario-novo">
        <h3>Dê sua opinião!</h3>
        <div class="comentario-novo-estrelas">
          <span v-for="i in 5" :key="i" :class="['star', { filled: i <= novoComentarioEstrelas }]" @click="novoComentarioEstrelas = i">★</span>
        </div>
        <textarea v-model="novoComentarioTexto" placeholder="Faça um comentário..." class="comentario-novo-textarea" rows="2"></textarea>
        <button class="comentario-novo-btn" @click="enviarComentario">Comentar</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import LocalInfo from '@/components/LocalInfo.vue';
import DialogCadastroLocal from '@/components/DialogCadastro/DialogCadastroLocal.vue';
import PesquisarLocal from '@/components/PesquisarLocal.vue';

const local = ref({
  nome: 'Travessia Poços de Caldas',
  owner: 'Henrique Maeda',
  phone: '(44) 98800-5555',
  capacity: 100,
  facilities: ['Banheiro', 'Energia', 'Internet', 'Rede de celular'],
  activities: ['Jornada', 'Acampamento', 'Day Use'],
  creator: 'Admin',
  image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
  fotos: [
    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
    'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=400&q=80',
    'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80',
  ]
});

const visivelDialogEdicao = ref(false);
const modalConfirmarExclusao = ref(false);

function scrollToComentario() {
  const el = document.getElementById('comentario-novo');
  if (el) el.scrollIntoView({ behavior: 'smooth' });
}

function onEditLocal() {
  visivelDialogEdicao.value = true;
}

function onDeleteLocal() {
  modalConfirmarExclusao.value = true;
}

function confirmarExclusao() {
  modalConfirmarExclusao.value = false;
  // Aqui você pode colocar a lógica real de inativação/exclusão
  alert('Local inativado!');
}

function abrirDialog(tipo: string) {
  // Lógica para abrir outros modais se necessário
  console.log('Abrir dialog:', tipo);
}

const comentarios = ref([
  { id: 1, nome: 'Raphael Ichiro', estrelas: 5, texto: 'Muito Bom!' },
  { id: 2, nome: 'Raquel Teixeira', estrelas: 1, texto: 'Péssimo!' },
  { id: 3, nome: 'Renan Sylos', estrelas: 3, texto: 'Mediano.' },
]);
const novoComentarioTexto = ref('');
const novoComentarioEstrelas = ref(0);
function enviarComentario() {
  if (novoComentarioTexto.value.trim() && novoComentarioEstrelas.value > 0) {
    comentarios.value.push({
      id: comentarios.value.length + 1,
      nome: 'Você',
      estrelas: novoComentarioEstrelas.value,
      texto: novoComentarioTexto.value,
    });
    novoComentarioTexto.value = '';
    novoComentarioEstrelas.value = 0;
  }
}
</script>

<style scoped>
.local-detalhe-prototipo {
  background: #f7f7f7;
  min-height: 100vh;
  padding: 0 0 32px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.local-detalhe-header {
  width: 100%;
  max-width: 1100px;
  margin: 32px auto 0 auto;
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
}
.local-title {
  font-size: 2rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.2em;
  display: flex;
  align-items: center;
  gap: 8px;
}
.stars {
  font-size: 1.5rem;
  color: #FFC107;
  margin-left: 8px;
  letter-spacing: 1px;
  display: inline-block;
}
.star {
  color: #ccc;
  font-size: 1.5em;
  cursor: pointer;
  transition: color 0.2s;
  user-select: none;
}
.star.filled {
  color: #FFC107;
}
.local-subtitle {
  color: #444;
  font-size: 1.1rem;
  margin-bottom: 12px;
}
.avaliar-btn {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.3rem 1.1rem;
  font-size: 1rem;
  cursor: pointer;
  margin-bottom: 8px;
  margin-top: 2px;
  transition: background 0.2s;
}
.avaliar-btn:hover {
  background: #176b43;
}
.local-detalhe-main {
  display: flex;
  gap: 32px;
  max-width: 1100px;
  width: 100%;
  margin: 0 auto 0 auto;
  align-items: flex-start;
}
.mapa-embed {
  flex: 2;
  max-width: 650px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
  background: #eaeaea;
  display: block;
}
.local-mapa-iframe {
  width: 100%;
  height: 320px;
  border: 0;
  border-radius: 16px;
  background: #eaeaea;
  display: block;
}
.local-detalhe-info {
  flex: 1;
  margin-left: 24px;
}
.local-detalhe-fotos {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  width: 100%;
}
.fotos-grid {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  margin-top: 0;
}
.foto {
  width: 260px;
  height: 170px;
  object-fit: cover;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  background: #eaeaea;
}
.local-detalhe-descricao {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem;
}
.local-detalhe-descricao h2 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.7em;
}
.local-detalhe-descricao p {
  color: #333;
  font-size: 1.05rem;
  margin-bottom: 1em;
}
.local-detalhe-comentarios {
  max-width: 1100px;
  margin: 32px auto 0 auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 2rem;
}
.comentarios-lista {
  display: flex;
  gap: 32px;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.comentario-item {
  min-width: 220px;
  max-width: 320px;
  flex: 1;
  background: #f7f7f7;
  border-radius: 8px;
  padding: 1rem 1.2rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.03);
  margin-bottom: 12px;
}
.comentario-nome {
  font-weight: 600;
  color: #222;
  margin-bottom: 0.2em;
}
.comentario-estrelas {
  margin-bottom: 0.5em;
}
.comentario-texto {
  color: #333;
  font-size: 1.05rem;
}
.comentario-novo {
  margin-top: 2rem;
  border-top: 1px solid #eee;
  padding-top: 1.5rem;
}
.comentario-novo h3 {
  font-size: 1.15rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.7em;
}
.comentario-novo-estrelas {
  margin-bottom: 0.7em;
}
.comentario-novo-textarea {
  width: 100%;
  border-radius: 6px;
  border: 1px solid #ccc;
  padding: 0.7em;
  font-size: 1rem;
  margin-bottom: 0.7em;
  resize: vertical;
  background: #f7f7f7;
  color: #222;
}
.comentario-novo-btn {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.comentario-novo-btn:hover {
  background: #176b43;
}
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.18);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.modal-confirm {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.13);
  min-width: 420px;
  max-width: 90vw;
  padding: 0;
  overflow: hidden;
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 1.1rem;
  font-weight: 600;
  padding: 1rem 1.2rem 0.5rem 1.2rem;
  border-bottom: 1px solid #eee;
}
.modal-header span {
  color: #222;
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #444;
}
.modal-body {
  padding: 1.2rem 1.2rem 0.5rem 1.2rem;
  font-size: 1.08rem;
  color: #222;
}
.modal-actions {
  display: flex;
  gap: 1rem;
  padding: 1rem 1.2rem 1.2rem 1.2rem;
}
.btn-sim {
  background: #219653;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-sim:hover {
  background: #176b43;
}
.btn-cancelar {
  background: #fff;
  color: #222;
  border: 1px solid #bbb;
  border-radius: 6px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-cancelar:hover {
  background: #f2f2f2;
}
@media (max-width: 1100px) {
  .local-detalhe-main, .local-detalhe-header, .local-detalhe-fotos {
    max-width: 98vw;
  }
  .foto {
    width: 45vw;
    min-width: 160px;
  }
}
@media (max-width: 900px) {
  .local-detalhe-main {
    flex-direction: column;
    gap: 24px;
  }
  .local-detalhe-info {
    margin-left: 0;
  }
  .fotos-grid {
    justify-content: center;
  }
}
</style> 
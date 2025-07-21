<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal-confirm">
      <div class="modal-header">
        <span class="modal-title">{{ titulo }}</span>
        <button class="modal-close" @click="$emit('cancelar')">✕</button>
      </div>
      <div class="modal-body">
        {{ texto }}
      </div>
      <div class="modal-actions">
        <button class="btn-sim" @click="$emit('confirmar')">Sim</button>
        <button class="btn-cancelar" @click="$emit('cancelar')">Cancelar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  visible: Boolean,
  titulo: { type: String, required: true },
  texto: { type: String, required: true }
});
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
.modal-confirm {
  background: #fff;
  border-radius: 16px;
  padding: 2rem;
  min-width: 350px;
  max-width: 90vw;
  box-shadow: 0 4px 24px rgba(0,0,0,0.12);
  position: relative;
}
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 1.2rem;
  font-weight: 600;
  color: #222;
  margin-bottom: 1.5rem;
}
.modal-title {
  font-weight: bold;
  font-size: 1.25rem;
  color: #222;
}
.modal-close {
  background: none;
  border: none;
  color: #888;
  font-size: 1.5rem;
  cursor: pointer;
  margin-left: 12px;
}
.modal-body {
  color: #222;
  margin-bottom: 2rem;
  font-size: 1.1rem;
}
.modal-actions {
  display: flex;
  gap: 16px;
  justify-content: flex-start;
}
.btn-sim {
  background: #22c55e;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.6rem 2.2rem;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-sim:hover {
  background: #16a34a;
}
.btn-cancelar {
  background: #fff;
  color: #222;
  border: 1.5px solid #c1c7cd;
  border-radius: 8px;
  padding: 0.6rem 2.2rem;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, border 0.2s;
}
.btn-cancelar:hover {
  background: #f3f4f6;
  border-color: #a3a3a3;
}
</style> 
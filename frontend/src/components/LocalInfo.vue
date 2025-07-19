<template>
  <section class="local-info">
    <header class="local-info__header">
      <h2 class="local-info__title">Informações</h2>
      <div class="local-info__actions">
        <button @click="$emit('edit')" title="Editar"><span class="icon">✏️</span></button>
        <button @click="$emit('delete')" title="Excluir"><span class="icon">🗑️</span></button>
      </div>
    </header>
    <ul class="local-info__list">
      <li><strong>Proprietário:</strong> {{ ownerName }}</li>
      <li><strong>Telefone:</strong> <a :href="whatsAppLink" target="_blank">{{ ownerPhone }}</a></li>
      <li><strong>Capacidade:</strong> {{ capacity }} pessoas</li>
      <li><strong>Instalações:</strong>
        <ul>
          <li v-for="facility in facilities" :key="facility">- {{ facility }}</li>
        </ul>
      </li>
      <li><strong>Atividades:</strong>
        <ul>
          <li v-for="activity in activities" :key="activity">- {{ activity }}</li>
        </ul>
      </li>
      <li><strong>Criador do cadastro:</strong> {{ creator }}</li>
    </ul>
    <button class="whatsapp-btn" :href="whatsAppLink" target="_blank">
      <span class="icon">💬</span> Chame agora
    </button>
  </section>
</template>

<script setup lang="ts">
import { computed, defineProps } from 'vue';

const props = defineProps<{
  ownerName: string;
  ownerPhone: string;
  capacity: number;
  facilities: string[];
  activities: string[];
  creator: string;
}>();

const whatsAppLink = computed(() => {
  const phone = props.ownerPhone.replace(/\D/g, '');
  return `https://wa.me/${phone}`;
});
</script>

<style scoped>
.local-info {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 1.5rem;
  max-width: 350px;
  color: #222;
}
.local-info__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}
.local-info__header h2 {
  color: #222;
}
.local-info__title {
  font-size: 1.35rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.5rem;
}
.local-info__actions button {
  background: none;
  border: none;
  cursor: pointer;
  margin-left: 0.5rem;
  font-size: 1.2rem;
}
.local-info__list {
  list-style: none;
  padding: 0;
  margin: 0 0 1.5rem 0;
  color: #222;
}
.local-info__list > li {
  margin-bottom: 0.5rem;
}
.local-info__list a {
  color: #219653;
  text-decoration: none;
}
.local-info__list a:hover {
  text-decoration: underline;
}
.whatsapp-btn {
  display: flex;
  align-items: center;
  background: #25d366;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.2s;
}
.whatsapp-btn:hover {
  background: #1ebe57;
}
.icon {
  margin-right: 0.5rem;
}
</style> 
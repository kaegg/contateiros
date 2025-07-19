<template>
  <div class="local-card">
    <div class="local-card__info">
      <div class="local-card__activities">
        <span
          v-for="activity in activities"
          :key="activity.name"
          class="local-card__activity"
        >
          <span class="local-card__activity-icon" v-html="activity.icon"></span>
          <span class="local-card__activity-name">{{ activity.name }}</span>
        </span>
      </div>
      <h2 class="local-card__title">
        <router-link :to="{ name: 'local-detalhe', params: { id: id } }" class="local-card__title-link">
          {{ title }}
        </router-link>
      </h2>
      <div class="local-card__location">{{ city }} - {{ state }}</div>
      <div class="local-card__rating">
        <span v-for="i in 5" :key="i" class="star">
          <svg v-if="i <= rating" width="18" height="18" viewBox="0 0 24 24" fill="#FFC107"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
          <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="#E0E0E0"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
        </span>
      </div>
      <div class="local-card__details">
        <div><strong>Proprietário:</strong> {{ owner }}</div>
        <div><strong>Fone:</strong> {{ phone }}</div>
        <div><strong>Capacidade estimada:</strong> {{ capacity }} pessoas</div>
      </div>
      <div class="local-card__facilities">
        <span v-for="facility in facilities" :key="facility" class="facility">#{{ facility }}</span>
      </div>
    </div>
    <div class="local-card__image">
      <img :src="image" :alt="title" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps<{
  id: string | number // Adicionar id para navegação
  activities: { name: string; icon: any }[]
  title: string
  city: string
  state: string
  rating: number
  owner: string
  phone: string
  capacity: number
  facilities: string[]
  image: string
}>()
</script>

<style scoped>
.local-card {
  display: flex;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
  overflow: hidden;
  margin: 16px 0;
  min-height: 280px;
  height: 280px;
  width: 100%;
  max-width: 600px;
}
.local-card__info {
  flex: 2;
  padding: 20px 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100%;
}
.local-card__activities {
  display: flex;
  gap: 12px;
  margin-bottom: 8px;
}
.local-card__activity {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 14px;
  color: #388e3c;
}
.local-card__activity-icon {
  font-size: 18px;
}
.local-card__title {
  font-size: 20px;
  font-weight: 700;
  margin: 0 0 4px 0;
  color: #219653;
}
.local-card__title-link {
  color: #219653;
  text-decoration: none;
  transition: text-decoration 0.2s;
}
.local-card__title-link:hover {
  text-decoration: underline;
}
.local-card__location {
  font-size: 15px;
  color: #757575;
  margin-bottom: 8px;
}
.local-card__rating {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}
.star {
  margin-right: 2px;
}
.local-card__details {
  font-size: 14px;
  color: #444;
  margin-bottom: 8px;
}
.local-card__facilities {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 8px;
}
.facility {
  background: #e8f5e8;
  color: #2e7d32;
  border-radius: 16px;
  padding: 4px 12px;
  font-size: 13px;
  font-weight: 500;
}
.local-card__image {
  flex: 1;
  min-width: 180px;
  max-width: 240px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5f5;
  height: 100%;
}
.local-card__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 0 16px 16px 0;
}
@media (max-width: 700px) {
  .local-card {
    flex-direction: column;
    height: auto;
    min-height: 400px;
  }
  .local-card__image {
    max-width: 100%;
    min-width: 100%;
    border-radius: 0 0 16px 16px;
    height: 200px;
  }
  .local-card__image img {
    border-radius: 0 0 16px 16px;
  }
}
</style> 
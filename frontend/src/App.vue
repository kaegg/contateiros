<!-- App.vue -->
<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import HeaderExt from '@/components/HeaderExt.vue';
</script>

<template>
  <header>
    <HeaderExt/>
  </header>

  <main>
    <RouterView />
  </main>
</template>

<style scoped>
</style>

<!-- App.vue -->
<script setup lang="ts">
  import { RouterView } from 'vue-router'
  import HeaderExt      from '@/components/Layout/HeaderExt.vue';
  // import FooterExt      from '@/components/Layout/FooterExt.vue';
</script>

<template>
  <header>
    <HeaderExt/>
  </header>

  <main>
    <RouterView />
  </main>

  <footer>
    <!-- <FooterExt/> -->
  </footer>
</template>

<style scoped>
</style>

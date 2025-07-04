<template>
  <header class="bg-white border-b shadow-sm px-6 py-4 flex items-center justify-between" id="headerExt">
    <!-- Esquerda: Logo e título -->
    <div class="flex items-center gap-2 cursor-pointer" @click="$router.push({ name: 'home' })">
      <span class="font-semibold text-2xl" id="logo">Contateiros</span>
    </div>

    <!-- Direita: Menu dropdown -->
    <div class="relative flex items-center">
      <div
        class="flex items-center gap-2 cursor-pointer text-gray-800 text-sm"
        @click="toggleMenu"
        ref="menuButton"
      >
        <div class="w-6 h-6 border border-black rounded-full flex items-center justify-center">
          <i class="pi pi-user text-gray-700 text-xl"></i>
        </div>

        <span class="text-base">Minha conta</span>
        <i class="pi pi-chevron-down text-base"></i>
      </div>

      <Menu
        ref="menu"
        :model="items"
        :popup="true"
        class="bg-white text-sm text-gray-800 rounded-md shadow-lg"
      />
    </div>
  </header>
</template>

<script setup lang="ts">
  import { ref } from 'vue'
  import Menu from 'primevue/menu'
  import 'primeicons/primeicons.css'

  const menu = ref();
  
  const toggleMenu = (event: MouseEvent) => {
    menu.value.toggle(event)
  }

  const items = ref([
    { label: 'Perfil', icon: 'pi pi-user'    , command: () => console.log('Perfil') },
    { label: 'Sair'  , icon: 'pi pi-sign-out', command: () => console.log('Sair') }
  ]);
</script>

<style scoped>
  #headerExt{
    border-bottom: 1px solid #C1C7CD;
  }

  #logo{
    font-size: 24px;
    color: #697077;
  }
</style>
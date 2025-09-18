<template>
    <footer
      class="bg-white border-t shadow-sm px-6 mt-8 py-4 flex items-center justify-center"
      id="footerExt"
    >
      <span class="text-gray-600 text-sm">&copy; {{ ano }} Contateiros. Todos os direitos reservados.</span>
    </footer>
</template>

<script setup lang="ts">
const ano = new Date().getFullYear();
</script>

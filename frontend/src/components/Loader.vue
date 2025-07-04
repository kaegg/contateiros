<template>
    <div v-if="isLoading" class="overlay-spinner">
        <ProgressSpinner aria-label="Loading" style="width:70px;height:70px;" />
    </div>
</template>

<script setup lang="ts">
    import { defineProps } from 'vue';
    import ProgressSpinner from 'primevue/progressspinner';
    
    const props = defineProps({
        isLoading: Boolean
    });

    console.log('Loader component loaded with isLoading:', props.isLoading);
</script>

<style scoped>
    .overlay-spinner {
        position: fixed;
        z-index: 9999;
        inset: 0;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: all;
    }

    /* Centraliza o spinner e bloqueia interação */
    body:has(.overlay-spinner) {
        overflow: hidden;
    }

</style>
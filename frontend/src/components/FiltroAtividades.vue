<template>
  <div class="card px-4 py-2 mt-5">
    <Carousel
      :value="filtros"
      :numVisible="3"
      :numScroll="1"
      :responsiveOptions="responsiveOptions"
      class="custom-carousel"
      :showIndicators="false"
    >
        <template #item="{ data }">
          <div
            class="flex flex-col items-center justify-center cursor-pointer mx-8 w-fit"
            @click="selecionarFiltro(data.value)"
            :class="filtroSelecionado === data.value ? 'text-green-600' : 'text-black'"
          >
            <div
              class="w-10 h-10 flex items-center justify-center rounded-full bg-white transition-all"
              :class="filtroSelecionado === data.value ? 'border-2 border-green-600' : 'border border-gray-300'"
            >
              <img v-if="data.icon && data.icon.startsWith('data:')" :src="data.icon" alt="ícone" class="w-6 h-6" />
              <i v-else :class="['text-2xl', data.icon || 'pi pi-star']" />
            </div>
            <span class="text-sm">{{ data.label }}</span>
          </div>
        </template>
    </Carousel>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted }  from 'vue'
import Carousel from 'primevue/carousel'
import { activityService } from '@/services/api.js'

interface Filtro {
  label: string;
  value: string;
  icon: string;
}

const filtroSelecionado = ref(null)
const filtros = ref<Filtro[]>([])

const responsiveOptions = [
  { breakpoint: '1024px', numVisible: 3, numScroll: 1 },
  { breakpoint: '768px',  numVisible: 2, numScroll: 1 },
  { breakpoint: '560px',  numVisible: 1, numScroll: 1 }
]

// Carregar atividades do backend
onMounted(async () => {
  try {
    const response = await activityService.getAll()
    if (response.success) {
      filtros.value = response.atividades.map((atividade: any) => ({
        label: atividade.nome,
        value: atividade.codigo.toLowerCase(),
        icon: atividade.icone || 'pi pi-star'
      }))
    } else {
      // Fallback caso não consiga carregar do backend
      filtros.value = [
        { label: 'Jornada',     value: 'jornada',     icon: 'pi pi-users' },
        { label: 'Acampamento', value: 'acampamento', icon: 'pi pi-home' },
        { label: 'Day Use',     value: 'dayuse',      icon: 'pi pi-sun' },
        { label: 'Trilhas',     value: 'trilhas',     icon: 'pi pi-compass' },
        { label: 'Eventos',     value: 'eventos',     icon: 'pi pi-calendar' },
      ]
    }
  } catch (error) {
    console.error('Erro ao carregar atividades:', error)
    // Fallback em caso de erro
    filtros.value = [
      { label: 'Jornada',     value: 'jornada',     icon: 'pi pi-users' },
      { label: 'Acampamento', value: 'acampamento', icon: 'pi pi-home' },
      { label: 'Day Use',     value: 'dayuse',      icon: 'pi pi-sun' },
      { label: 'Trilhas',     value: 'trilhas',     icon: 'pi pi-compass' },
      { label: 'Eventos',     value: 'eventos',     icon: 'pi pi-calendar' },
    ]
  }
})

function selecionarFiltro(valor: any) {
  filtroSelecionado.value = valor
}
</script>

<style scoped>
.custom-carousel .p-carousel-item {
  display: flex;
  justify-content: center;
}

.custom-carousel ::v-deep(.p-carousel-indicators) {
  display: none !important;
}
</style>

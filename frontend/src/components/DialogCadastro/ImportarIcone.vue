<template>

    <label class="block mb-2 font-semibold text-black">{{ props.label }}</label>

    <div class="flex items-center gap-3">
        <div id="imagemImportada" class="w-20 h-20 rounded-lg border border-dashed border-gray-400 flex items-center justify-center overflow-hidden">

            <img v-if="imagemPreview" :src="imagemPreview" alt="Preview" class="w-full h-full object-cover rounded-lg"/>
            <i v-else class="pi pi-image text-3xl text-gray-400"></i>
        
        </div>

        <div class="flex flex-col gap-2">
            <Button size="small" class="btSalvar rounded-2xl! px-2! py-1!" @click="selecionarImagem">
                <i class="pi pi-plus"></i>
                Adicionar
            </Button>
          
            <Button size="small" class="text-white! border border-orange-600! bg-orange-600! hover:bg-orange-700! hover:border-orange-700! rounded-2xl! px-2! py-1!" @click="removerImagem">
                <i class="pi pi-trash"></i>
                Remover
            </Button>
        </div>
    </div>

    <input type="file" accept="image/*" ref="inputImagem" class="hidden" @change="carregarImagem" />

</template>

<script setup lang="ts">
    import { defineProps, ref, defineEmits } from 'vue';

    const props = defineProps({
        label: String,
    });

    const emit = defineEmits(['imagem-selecionada']);

    const inputImagem       = ref<HTMLInputElement | null>(null);
    const imagemPreview     = ref<string | null>(null);
    const imagemSelecionada = ref<File | null>(null);

    function selecionarImagem() {
        inputImagem.value?.click();
    }

    function carregarImagem(event: Event) {
        const file = (event.target as HTMLInputElement)?.files?.[0];

        if (file && file.type.startsWith("image/")) {
            imagemSelecionada.value = file;

            const reader = new FileReader();

            reader.onload = (e) => {
                imagemPreview.value = e.target?.result as string;
            };

            reader.readAsDataURL(file);
        }

        emit('imagem-selecionada', file);
    }

    function removerImagem() {
        imagemPreview.value     = null;
        imagemSelecionada.value = null;
        if (inputImagem.value) inputImagem.value.value = '';

        emit('imagem-selecionada', null);
    }

    defineExpose({ removerImagem });
</script>

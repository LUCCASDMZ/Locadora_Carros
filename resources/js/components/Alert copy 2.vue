<template>
    <div v-if="mensagem" :class="`alert alert-${tipo}`" role="alert">
        <span>
            {{ formattedMessage }}
        </span>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    tipo: {
        type: String,
        required: true
    },
    mensagem: {
        type: [String, Array],
        required: true
    }
});

const formattedMessage = computed(() => {
    return Array.isArray(props.mensagem) ? props.mensagem.join(' ') : props.mensagem;
});
</script>

<style scoped>

</style>
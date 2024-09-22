<template>
    <transition name="fade">
        <div v-if="visivel" :class="['alert', `alert-${tipo}`]" role="alert">
            <ul v-if="Array.isArray(mensagem)">
                <li v-for="(msg, index) in mensagem" :key="index">{{ msg }}</li>
            </ul>
            <template v-else>{{ mensagem }}</template>
        </div>
    </transition>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    tipo: {
        type: String,
        default: 'info'
    },
    mensagem: {
        type: [String, Array],
        required: true
    },
    duracao: {
        type: Number,
        default: 0
    }
});

const visivel = ref(false);

watch(() => props.mensagem, () => {
    visivel.value = true;
    if (props.duracao > 0) {
        setTimeout(() => { visivel.value = false; }, props.duracao);
    }
}, { immediate: true });
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.5s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
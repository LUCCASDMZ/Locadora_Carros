<template>
    <div v-if="mensagem" :class="`alert alert-${tipo}`" role="alert">
        {{ mensagem }}
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const tipo = computed(() => store.state.transacao.status);
const mensagem = computed(() => store.state.transacao.mensagem);
</script>

<style scoped>
/* Estilos para o alerta */
</style>
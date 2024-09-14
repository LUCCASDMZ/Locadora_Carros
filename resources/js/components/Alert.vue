<template>
    <div :class="estilo" role="alert">
    A mensagem de feedback
        {{ tipo }}
    </div>
</template>

<script setup>
import { computed } from 'vue';


const props = defineProps(['tipo'])

const estilo = computed(() => {
        return 'alert alert-'+ props.tipo
    });

</script>

<style lang="scss" scoped>

</style>
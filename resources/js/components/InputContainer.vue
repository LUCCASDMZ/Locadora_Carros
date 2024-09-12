<template>
    <div class="form-group">
        <label :for="id" class="form-label">{{ titulo }}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text">{{ textoAjuda }}</div>
    </div>
</template>

<script setup>

    defineProps (['id', 'titulo', 'idHelp', 'textoAjuda']);

</script>

<style scoped>

    

</style>
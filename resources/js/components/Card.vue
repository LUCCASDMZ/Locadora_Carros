<template>

        <div class="card mb-4">
            <div class="card-header">{{ titulo }}</div>
                <div class="card-body">
                    <slot></slot>      
                </div>
        </div>

</template>

<script setup>

    defineProps(['titulo', ])

</script>

<style lang="scss" scoped>

</style>
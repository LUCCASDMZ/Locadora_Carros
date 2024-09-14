<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="coluna in colunas" :key="coluna.chave" scope="col">{{ coluna.titulo }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in itens" :key="item[chaveUnica]">
                <td v-for="coluna in colunas" :key="coluna.chave">
                    <slot :name="coluna.chave" :item="item">
                        {{ item[coluna.chave] }}
                    </slot>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    colunas: {
        type: Array,
        required: true
    },
    itens: {
        type: Array,
        required: true
    },
    chaveUnica: {
        type: String,
        default: 'id'
    }
});
</script>
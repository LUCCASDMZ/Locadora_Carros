<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th v-for="coluna in colunas" :key="coluna.chave" scope="col" :class="coluna.class">{{ coluna.titulo }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in itens" :key="item[chaveUnica]">
                <td v-for="coluna in colunas" :key="coluna.chave">
                    <slot :name="coluna.chave" :item="item">
                        {{ item[coluna.chave] }}
                    </slot>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary btn-sm" @click="$emit('visualizar', item)">Visualizar</button>
                        <button class="btn btn-info btn-sm ms-2" @click="$emit('atualizar', item)">Atualizar</button>
                        <button class="btn btn-danger btn-sm ms-2" @click="$emit('excluir', item.id)">Excluir</button>
                    </div>
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
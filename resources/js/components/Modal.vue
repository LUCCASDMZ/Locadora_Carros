<template>
  <Teleport to="body">
    <div v-if="show" class="modal fade show" :id="id" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">{{ titulo }}</h5>
            <button type="button" class="btn-close" @click="fecharModal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <slot name="alertas"></slot>
            <slot name="conteudo"></slot>
          </div>
          <div class="modal-footer">
            <slot name="rodape"></slot>
          </div>
        </div>
      </div>
    </div>
    <div v-if="show" class="modal-backdrop fade show"></div>
  </Teleport>
</template>

<script setup>
import { defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
  show: Boolean,
  id: String,
  titulo: String
});

const emit = defineEmits(['update:show', 'excluirMarca']);

const fecharModal = () => {
  emit('update:show', false);
};

watch(() => props.show, (novoValor) => {
  if (novoValor) {
    document.body.classList.add('modal-open');
  } else {
    document.body.classList.remove('modal-open');
  }
});
</script>

<style scoped>
.modal-open {
  overflow: hidden;
}
</style>
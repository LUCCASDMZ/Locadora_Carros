<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Card titulo="Busca de Marcas">
<!-- --------------------------------------------------BUSCAR MARCAS-------------------------------------------------- -->                    
                        <div class="row g-3"> 
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca"> 
                                    <input v-model="inputID" type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>       
                            </div>                    

                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca"> 
                                    <input v-model="inputMarca" type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component> 
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary btn-sm ms-auto" @click="listMarcas">Pesquisar</button>
                        </div>
                </Card>

<!-- --------------------------------------------------MARCAS-------------------------------------------------- -->

 <!-- --------------------ALERTS GLOBAIS--------------------> 
                <Alert 
                    v-if="store.state.transacao.mensagem && modo !== 'adicionar'"
                    :tipo="store.state.transacao.status"
                    :mensagem="store.state.transacao.mensagem"
                />
<!-- --------------------FIM----------------------->                

                <card titulo="Relações de Marcas">
                    <Table :colunas="colunas" :itens="listaMarcas" 
                           @visualizar="openModal('visualizar', $event)" 
                           @atualizar="openModal('atualizar', $event)" 
                           @excluir="excluirMarca($event)">
                        <template #imagem="{ item }">
                            <img v-if="item.imagem" :src="'storage/'+item.imagem" alt="Imagem da marca" style="max-width: 50px; max-height: 50px;">
                            <span v-else>Sem imagem</span>
                        </template>

                    </Table>

                    <div class="row">
                        <div class="col-10">
                            
                            <Paginate>
                                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Anterior</a>
                                </li>
                                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: currentPage === page }">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Próxima</a>
                                </li>
                            </Paginate>
                        </div>

                        <div class="col">
                            <button type="button" class="btn btn-primary btn-sm ms-auto" @click="openModal('adicionar')">Adicionar</button>
                        </div>
                    </div>
                </card>
                



<!-- -------------------------------------------------- MODAL MARCAS-------------------------------------------------- -->                    
                <Modal 
                    v-model:show="showModal" 
                    id="modalMarca" 
                    :titulo="modalTitulo"
                    @excluirMarca="excluirMarca"
                >
<!-- --------------------ALERTS NO MODAL-------------------->                
                    <template #alertas>
                        <Alert 

                            :tipo="store.state.transacao.status"
                            :mensagem="store.state.transacao.mensagem"
                        />
                    </template>
<!-- --------------------FIM----------------------->

<!-- --------------------INPUT MARCAS-------------------->
                    <template #conteudo>
                        <div v-if="modo === 'adicionar'">
                            <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca">
                                <input v-model="nomeMarca" type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca">
                            </input-container-component>

                            <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione a Imagem da marca">
                                <input @change="fileUpload" type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" accept="image/png">
                            </input-container-component>
                        </div>

                        <div v-else-if="modo === 'visualizar'">
                            <p>ID: {{ marcaSelecionada.id }}</p>
                            <p>Nome: {{ marcaSelecionada.nome }}</p>
                            <img v-if="marcaSelecionada.imagem" :src="'storage/'+marcaSelecionada.imagem" alt="Imagem da marca" style="max-width: 100px;">
                        </div>

                        <div v-else-if="modo === 'atualizar'">
                            <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o novo nome da marca">
                                <input v-model="marcaSelecionada.nome" type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da marca">
                            </input-container-component>
                            <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione a nova imagem da marca">
                                <input @change="fileUpload" type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" accept="image/png">
                            </input-container-component>
                        </div>
                    </template>

                    <template #rodape>
                        <button type="button" class="btn btn-secondary" @click="closeModal">Fechar</button>
                        <button v-if="modo === 'adicionar'" @click="submitFile" type="button" class="btn btn-primary">Salvar</button>
                        <button v-if="modo === 'atualizar'" @click="updateMarca" type="button" class="btn btn-primary">Atualizar</button>
                    </template>
                </Modal>
<!-- --------------------------------------------------FIM-------------------------------------------------- -->     
                
            </div>
        </div>
    </div>
</template>

<script setup>
import InputContainerComponent from './InputContainer.vue';
import Table from './Table.vue';
import Card from './Card.vue';
import Modal from './Modal.vue'
import Alert from './Alert.vue';
import Paginate from './Paginate.vue';
import { computed, onMounted, ref, watch } from 'vue';
import { useStore } from 'vuex'; // {{ edit_1 }}

const inputID = ref('')
const inputMarca = ref('')

const modo = ref('adicionar'); // 'adicionar', 'visualizar' ou 'atualizar'
const marcaSelecionada = ref({}); // Para armazenar a marca selecionada

const listaMarcas = ref([]);
const nomeMarca = ref('');
const file = ref(null);
const showModal = ref(false);

const currentPage = ref(1);
const totalPages = ref(0);

const store = useStore(); // {{ edit_2 }}

//  --------------------------------------------------MODAL--------------------------------------------------
const openModal = (tipo, item = null) => {
    modo.value = tipo;
    if (tipo === 'visualizar' || tipo === 'atualizar') {
        marcaSelecionada.value = { ...item }; // Armazena a marca selecionada
    } else {
        marcaSelecionada.value = {}; // Limpa a seleção ao adicionar
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    nomeMarca.value = '';
    file.value = null;
};

//-----------------------------------------------------------FIM----------------------------------------------------------

//  --------------------------------------------------ATUALIZAR MARCAS--------------------------------------------------

// Função para atualizar a marca
const updateMarca = async () => {
    const formData = new FormData();
    formData.append('nome', marcaSelecionada.value.nome);
    
    // Adicione a chave _method para simular o método PUT
    formData.append('_method', 'PUT');

    if (file.value) {
        formData.append('imagem', file.value);
    }

    try {
        await axios.post(`http://127.0.0.1:8000/api/marca/${marcaSelecionada.value.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json'
            }
        });
        store.commit('setTransacao', { status: 'success', mensagem: 'Marca atualizada com sucesso!' });
        setTimeout(closeModal, 4000);
        await listMarcas(); // Atualiza a lista de marcas após a atualização
    } catch (error) {
        console.error('Erro ao atualizar marca:', error);
        store.commit('setTransacao', { status: 'danger', mensagem: 'Erro ao atualizar marca.' });
    }
};
//-----------------------------------------------------------FIM----------------------------------------------------------

//  --------------------------------------------------LISTAR MARCAS--------------------------------------------------
const listMarcas = async() => {
    try {
        const params = {};

        // Construção do filtro
        if(inputMarca.value){
            params.filtro = `nome:like:${inputMarca.value}%`;
            currentPage.value = 1;
        }

        if(inputID.value){
            params.filtro = `id:=:${inputID.value}`
            currentPage.value = 1;
        }

        const response = await axios.get('http://127.0.0.1:8000/api/marca', {
            params: {
                ...params,
                page: currentPage.value // Envie a página atual como parâmetro
            }
        });
        listaMarcas.value = response.data.data; // Armazene os dados da marca
        totalPages.value = response.data.last_page; // Armazene o total de páginas

    } catch (error) {
        console.error('Erro ao buscar marcas:', error);
    }
};

//-----------------------------------------------------------FIM----------------------------------------------------------


//  --------------------------------------------------ADICIONAR MARCAS--------------------------------------------------
const fileUpload = (event) => {
    file.value = event.target.files[0];
}

const submitFile = async() => {
    const formData = new FormData();
    formData.append('nome', nomeMarca.value);
    
    if (file.value) {
        formData.append('imagem', file.value);
    }

    try {
        await axios.post('http://127.0.0.1:8000/api/marca', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json'
            }
        });
        store.commit('setTransacao', { status: 'success', mensagem: 'Marca adicionada com sucesso!' });
        setTimeout(closeModal, 3000);
    } catch (error) {
        store.commit('setTransacao', { 
            
        status: 'danger', 
        mensagem: Object.values(error.response?.data?.errors || {}).flat(), // Organiza a mensagem em múltiplas linhas
        });
    }
}
//-----------------------------------------------------------FIM----------------------------------------------------------


//  --------------------------------------------------EXCLUIR MARCAS--------------------------------------------------
const excluirMarca = async (id) => {
    try {
        await axios.delete(`http://127.0.0.1:8000/api/marca/${id}`);
        store.commit('setTransacao', { status: 'success', mensagem: 'Marca excluída com sucesso!' });

        currentPage.value = 1; // Redefine a página atual para 1
        await listMarcas(); // Atualiza a lista de marcas após a exclusão

    } catch (error) {
        store.commit('setTransacao', { status: 'danger', mensagem: 'Erro ao excluir marca. Por favor, tente novamente.' });

        // Limpar a mensagem após 4 segundos
        setTimeout(() => {
            store.commit('clearTransacao');
        }, 4000); // 4000 milissegundos = 4 segundos
    }
};


const colunas = [
    { chave: 'id', titulo: 'ID' },
    { chave: 'nome', titulo: 'Nome' },
    { chave: 'imagem', titulo: 'Imagem' },
    { chave: 'acoes', titulo: '', class: 'text-center' }
];

onMounted(listMarcas);

// Função única para mudar de página
const changePage = async (page) => {
    if (page > 0 && page <= totalPages.value) {
        currentPage.value = page; // Atualiza a página atual
        await listMarcas(); // Chama a função para buscar marcas da nova página
    }
};

const modalTitulo = computed(() => {
    if (modo.value === 'adicionar') return 'Adicionar Marca';
    if (modo.value === 'visualizar') return 'Visualizar Marca';
    if (modo.value === 'atualizar') return 'Atualizar Marca';
    return '';
});

// Computed para a mensagem de alerta
const showAlert = computed(() => store.state.transacao.mensagem);

// Watcher para limpar a mensagem após 5 segundos
watch(showAlert, (newValue) => {
    if (newValue) {
        setTimeout(() => {
            store.commit('clearTransacao'); // Limpa a mensagem após 5 segundos
        }, 5000);
    }
});

onMounted(() => {
    console.log('Mensagem de transação:', store.state.transacao.mensagem); // Verifique a mensagem
});

</script>

<style scoped>

</style>
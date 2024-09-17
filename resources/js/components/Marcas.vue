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

 <!-- --------------------ALERTS--------------------> 
                <Alert 
                    v-if="alertaMensagemPrincipal"
                    :tipo="alertaTipoPrincipal"
                    :mensagem="alertaMensagemPrincipal"
                    :duracao="5000"
                />
<!-- --------------------FIM----------------------->                

                <card titulo="Relações de Marcas">
                    <Table :colunas="colunas" :itens="listaMarcas">
                        <template #imagem="{ item }">
                            <img v-if="item.imagem" :src="'storage/'+item.imagem" alt="Imagem da marca" style="max-width: 50px; max-height: 50px;">
                            <span v-else>Sem imagem</span>
                        </template>
                        <template #acoes="{ item }">
                            <div class="d-flex justify-content-center"> <!-- Centralizando os botões -->
                                <button class="btn btn-primary btn-sm">Visualizar</button>
                                <button class="btn btn-info btn-sm" >Atualizar</button>
                                <button class="btn btn-danger btn-sm" @click="excluirMarca(item.id)">Excluir</button>
                            </div>
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
                            <button type="button" class="btn btn-primary btn-sm ms-auto" @click="openModal">Adicionar</button>
                        </div>
                    </div>
                </card>
                

<!-- -------------------------------------------------- MODAL MARCAS-------------------------------------------------- -->                    
                <Modal 
                    v-model:show="showModal" 
                    id="modalMarca" 
                    titulo="Adicionar marca"
                    @excluirMarca="excluirMarca"
                >
<!-- --------------------ALERTS-------------------->                
                    <template #alertas>
                        <Alert 
                            v-if="alertaMensagem"
                            :tipo="alertaTipo"
                            :mensagem="alertaMensagem"
                            :duracao="5000"
                        />
                    </template>
<!-- --------------------FIM----------------------->

<!-- --------------------INPUT MARCAS-------------------->
                    <template #conteudo>
                        <div class="form-group mb-4">
                            
                            <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca">
                                <input v-model="nomeMarca" type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca">
                            </input-container-component>
                        </div>

                        <div class="form-group mb-4">
                            <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione a Imagem da marca">
                                <input @change="fileUpload" type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" accept="image/png">
                            </input-container-component>
                        </div>
                    </template>

                    <template #rodape>
                        <button type="button" class="btn btn-secondary" @click="closeModal">Fechar</button>
                        <button @click="submitFile" type="button" class="btn btn-primary">Salvar</button>
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
import { onMounted, ref } from 'vue';

const inputID = ref('')
const inputMarca = ref('')

const listaMarcas = ref([]);
const nomeMarca = ref('');
const file = ref(null);
const showModal = ref(false);
const alertaTipo = ref('');
const alertaMensagem = ref('');

const alertaTipoPrincipal = ref('');
const alertaMensagemPrincipal = ref('');

const currentPage = ref(1);
const totalPages = ref(0);

//  --------------------------------------------------MODAL--------------------------------------------------
const openModal = () => {
    showModal.value = true;
    alertaMensagem.value = '';
};

const closeModal = () => {
    showModal.value = false;
    nomeMarca.value = '';
    file.value = null;
    alertaMensagem.value = '';
};

//-----------------------------------------------------------FIM----------------------------------------------------------

//  --------------------------------------------------ADICIONAR MARCAS--------------------------------------------------
const fileUpload = (event) => {
    file.value = event.target.files[0];
}

const submitFile = async() => {
    alertaMensagem.value = '';

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
        alertaTipo.value = 'success';
        alertaMensagem.value = 'Marca adicionada com sucesso!';
        setTimeout(closeModal, 4000);

    } catch (error) {
        alertaTipo.value = 'danger';
        alertaMensagem.value = Object.values(error.response?.data?.errors || {}).flat();
    }
}
//-----------------------------------------------------------FIM----------------------------------------------------------

//  --------------------------------------------------LISTAR MARCAS--------------------------------------------------
const listMarcas = async() => {
    try {
        const params = {};

        // Construção do filtro
        if(inputMarca.value){
            params.filtro = `nome:like:${inputMarca.value}%`;
            
            // Redefine a página atual para 1 ao fazer uma nova pesquisa
            currentPage.value = 1;
        }

        if(inputID.value){
            params.filtro = `id:=:${inputID.value}`

            // Redefine a página atual para 1 ao fazer uma nova pesquisa
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

const excluirMarca = async (id) => {
    try {
        await axios.delete(`http://127.0.0.1:8000/api/marca/${id}`);
        alertaTipoPrincipal.value = 'success';
        alertaMensagemPrincipal.value = 'Marca excluída com sucesso!';

        inputID.value = '';
        inputMarca.value = '';
        
        // Chama a função para listar marcas após a exclusão
        await listMarcas(); // Atualiza a lista de marcas após a exclusão
        console.log('Lista de marcas atualizada após exclusão.'); // Verificação

        // Limpa a mensagem após 5 segundos
        setTimeout(() => {
            alertaMensagemPrincipal.value = '';
        }, 5000);
    } catch (error) {
        alertaTipoPrincipal.value = 'danger';
        alertaMensagemPrincipal.value = 'Erro ao excluir marca. Por favor, tente novamente.';
        if (error.response) {
            console.error('Detalhes do erro:', error.response.data);
        }
        
        // Limpa a mensagem de erro após 5 segundos
        setTimeout(() => {
            alertaMensagemPrincipal.value = '';
        }, 5000);
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

</script>

<style scoped>

</style>
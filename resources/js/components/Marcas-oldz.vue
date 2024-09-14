<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Card titulo="Busca de Marcas">
                        <div class="row g-3"> 
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca"> 
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>       
                            </div>                    

                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca"> 
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component> 
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">Pesquisar</button>
                        </div>
                </Card>

                <card titulo="Relações de Marcas">
                    <Table></Table>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </div>
                </card>

                <Modal id="modalMarca" titulo="Adicionar marca">
                    <template v-slot:conteudo>
                        <div class="form-group mb-4">
                            
                            <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                <input v-model="nomeMarca" type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca">
                            </input-container-component>
                        </div>

                        <div class="form-group mb-4">
                            <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Opcional. Selecione a Imagem da marca">
                                <input @change="fileUpload" type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Imagem da marca">
                            </input-container-component>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button @click="submitFile" type="button" class="btn btn-primary">Salvar</button>
                    </template>
                </Modal>
                
                
            </div>
        </div>
    </div>
    </template>
    
    <script setup>
    import InputContainerComponent from './InputContainer.vue';
    import Table from './Table.vue';
    import Card from './Card.vue';
    import Modal from './Modal.vue'
    import { ref } from 'vue';
    
    const nomeMarca = ref('');
    const file = ref(null);

    const fileUpload = (event) => {
        file.value = event.target.files[0];
    }

    const submitFile = async() => {
        if(!file.value){
            alert('Por favor, selecione um arquivo');
            return;
        }
        const formData = new FormData();
            formData.append('nome', nomeMarca.value)
            formData.append('imagem', file.value);

        try{
            const response =  await axios.post('http://127.0.0.1:8000/api/marca',formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            nomeMarca.value = ''
            file.value = null
        } catch (error){
            console.error('Erro ao adicionar a marca:', error)
        }

    }
    
    
    </script>
    
    <style lang="scss" scoped>
    
    </style>
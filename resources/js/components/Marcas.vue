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
                        <button type="button" class="btn btn-primary btn-sm ms-auto">Adicionar</button>
                    </div>
                </card>
                
            </div>
        </div>
    </div>
    </template>
    
    <script setup>
    import InputContainerComponent from './InputContainer.vue';
    import Table from './Table.vue';
    import Card from './Card.vue';
    
    
    </script>
    
    <style lang="scss" scoped>
    
    </style>
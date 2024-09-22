/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/*importando e configurando o vuex */
import { createStore } from 'vuex'

const store = createStore({
    state: {
        transacao: { status: '', mensagem: '' } 
    },
    mutations: {
        setTransacao(state, payload) {
            state.transacao.status = payload.status;
            state.transacao.mensagem = payload.mensagem;
        },
        clearTransacao(state) {
            state.transacao.status = '';
            state.transacao.mensagem = '';
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(store); // Adiciona a store à instância do Vue

import loginComponent from './components/login.vue';
app.component('login-component', loginComponent);

import registerComponent from './components/Register.vue';
app.component('register-component', registerComponent);

import homeComponent from './components/home.vue';
app.component('home-component', homeComponent);

import marcasComponent from './components/Marcas.vue';
app.component('marcas-component', marcasComponent);

import modelosComponent from './components/Modelos.vue';
app.component('modelos-component', modelosComponent);

import inputcontainerComponent from './components/InputContainer.vue';
app.component('inputcontainer-component', inputcontainerComponent);

import tableComponent from './components/Table.vue';
app.component('table-component', tableComponent);

import cardComponent from './components/Card.vue';
app.component('card-component', cardComponent);

import modalComponent from './components/Modal.vue';
app.component('modal-component', modalComponent);

import alertComponent from './components/Alert.vue';
app.component('alert-component', alertComponent);

import paginateComponent from './components/Paginate.vue';
app.component('paginate-component', paginateComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

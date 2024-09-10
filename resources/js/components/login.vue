<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login componente</div>
                <div class="card-body">
                    <form method="POST" action="" @submit.prevent="login">
                        <input type="hidden" name="_token" :value="csrf_token">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus v-model="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        Mantenha-me conectado
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                    <a class="btn btn-link" href="">
                                        Esqueci a senha
                                    </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps(['csrf_token']);

const email = ref('');
const password = ref('');

const login = async (e) => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    });

    if (response.data.token) {
    document.cookie = `token=${response.data.Token}; path=/; max-age=86400; SameSite=Lax; Secure`;
    }

  } catch (error) {
    console.error('Erro ao fazer login:', error);
  }
  e.target.submit()
};

</script>

<style scoped>

</style>
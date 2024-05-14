<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>
        <div class="container mx-auto py-12 px-6 flex flex-wrap justify-end">
            <div class="flex flex-wrap w-full">
                <div class="w-full px-4">
                    <div class="relative flex flex-col min-w-0 break-words w-full shadow-lg rounded-lg bg-gray-300 dark:bg-gray-700 border-0">
                        <div class="rounded-t bg-white dark:bg-gray-800 mb-0 px-6 py-6">
                            <div class="text-center flex justify-between">
                                <h6 class="text-gray-800 dark:text-gray-200 text-xl font-bold">{{transportadora ? 'Atualizar' : 'Adicionar'}} Transportadora</h6>
                            </div>
                        </div>
                        <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                            <Form id="createForm" @submit="onSubmit">
                                <h6 class="text-gray-500 dark:text-gray-100 text-sm mt-6 font-bold uppercase">Informações da Transportadora</h6>
                                <div class="flex flex-wrap -mx-4">
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="nome">
                                            Nome
                                        </label>
                                        <Field type="text" v-model="form.nome" :rules="validadeNome" id="nome" name="nome" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Nome da Transportadora" style="transition: all 0.15s ease 0s;" />
                                        <ErrorMessage name="nome" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="limite_credito">
                                            Limite de crédito
                                        </label>
                                        <input v-money="money" type="text" v-model.lazy="form.limite_credito" id="limite_credito" name="limite_credito" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Limite de Crédito" style="transition: all 0.15s ease 0s;">
                                        <span v-if="form.errors.limite_credito" class="text-red-400 text-xs block mt-2">{{ form.errors.limite_credito }}</span>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="nome">
                                            Data da análise
                                        </label>
                                        <Field type="date" :rules="required" v-model="form.data_analise_credito" id="data_analise_credito" name ="data_analise_credito" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Data da Análise"style="transition: all 0.15s ease 0s;"/>
                                        <ErrorMessage name="data_analise_credito" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="cep">
                                            CEP
                                        </label>
                                        <input type="text" v-mask="['#####-###']" v-model="form.cep" @blur="checkCEP" id="cep" name="cep" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="12345-123" style="transition: all 0.15s ease 0s;">
                                        <span v-if="form.errors.cep" class="text-red-400 text-xs block mt-2">{{ form.errors.cep }}</span>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="endereco">
                                            Endereço
                                        </label>
                                        <Field type="text" v-model="form.endereco" :rules="required" id="endereco" name="endereco" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Endereço" style="transition: all 0.15s ease 0s;" />
                                        <ErrorMessage name="endereco" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="bairro">
                                            Bairro
                                        </label>
                                        <Field type="text" v-model="form.bairro" :rules="required" id="bairro" name="bairro" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Bairro" style="transition: all 0.15s ease 0s;" />
                                        <ErrorMessage name="bairro" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="cidade">
                                            Cidade
                                        </label>
                                        <Field type="text" v-model="form.cidade" :rules="required" id="cidade" name="cidade" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="Cidade" style="transition: all 0.15s ease 0s;"/>
                                        <ErrorMessage name="cidade" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4 mt-8">
                                        <label class="block uppercase text-gray-400 text-xs font-bold mb-2" for="uf">
                                            UF
                                        </label>
                                        <Field type="text" v-model="form.uf" :rules="validateUF" id="uf" name="uf" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full dark:bg-gray-800 dark:text-gray-200" placeholder="UF" style="transition: all 0.15s ease 0s;"/>
                                        <ErrorMessage name="uf" class="text-red-400 text-xs block mt-2" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex justify-end w-full">
                        <button @click="$inertia.visit(route('dashboard'))" class=" text-white hover:bg-gray-700 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-2 mb-1 mt-8" type="button" style="transition: all 0.15s ease 0s;">
                            Voltar
                        </button>
                        <button type="submit" form="createForm" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 mt-8" style="transition: all 0.15s ease 0s;">
                            {{transportadora ? 'Atualizar' : 'Adicionar'}} Transportadora
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script>
import DashboardTable from '@/Components/Dashboard/DashboardTable.vue';
import TablePagination from '@/Components/Dashboard/TablePagination.vue';
import {mask} from 'vue-the-mask'
import {VMoney} from 'v-money'
import { Form, Field, ErrorMessage } from 'vee-validate';
import { useForm } from '@inertiajs/vue3'

export default {
    name: 'Dashboard',
    props: ['transportadora'],
    components: {DashboardTable, TablePagination, Form, Field, ErrorMessage},
    directives: {mask, money: VMoney},
    data: () => ({
        form: useForm({
            nome: '',
            limite_credito: '',
            data_analise_credito: '',
            endereco: '',
            cidade: '',
            uf: '',
            bairro: '',
            cep: '',
        }),
        UFs: ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'],
        money: {
            decimal: ',',
            thousands: '.',
            prefix: 'R$ ',
            precision: 2,
        }
    }),
    methods: {
        checkCEP(){
            axios.get('https://viacep.com.br/ws/'+this.form.cep+'/json/')
            .then(response => {
                this.form.endereco = response.data.logradouro
                this.form.bairro = response.data.bairro
                this.form.cidade = response.data.localidade
                this.form.uf = response.data.uf
            })
        },
        onSubmit(values) {
            if(this.transportadora){
                this.form.put(route('transportadora.update', this.transportadora.uuid), {
                    preserveScroll: true,
                })
                return
            }
            this.form.post(route('transportadora.store'), {
                preserveScroll: true,
            })
        },
        validadeNome(value){
            if(value.length < 3){
                return 'Nome deve ter no mínimo 3 caracteres'
            }
            return true;
        },
        validateUF(value){
            if(value.length !== 2){
                return 'UF deve ter 2 caracteres'
            }
            if (!this.UFs.includes(value)){
                return 'UF inválida'
            }
            return true;
        },
        required(value){
            if(!value){
                return 'Campo obrigatório'
            }
            return true;
        }
    },
    created(){
        if (this.transportadora) {
            this.form.nome = this.transportadora.nome
            this.form.limite_credito = this.transportadora.limite_credito
            this.form.data_analise_credito = new Date(this.transportadora.data_analise_credito).toISOString().slice(0,10)
            this.form.endereco = this.transportadora.endereco
            this.form.cidade = this.transportadora.cidade
            this.form.uf = this.transportadora.uf
            this.form.bairro = this.transportadora.bairro
        }
    }
}
</script>
<style>
input {
  color-scheme: dark;
}
</style>
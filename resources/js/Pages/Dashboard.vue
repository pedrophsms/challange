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
            <div class="flex items-center justify-between w-full mb-8">
                <h3 class="text-3xl dark:text-white">Transportadoras</h3>
                <div class="flex items-center">
                    <a @click="exportDialog = true" class="text-white border cursor-pointer border-gray-700 hover:bg-gray-800 focus:ring-4 mr-3 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center ">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                        Exportar Lista
                    </a>
                    <inertia-link :href="route('transportadora.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                        Adicionar Transportadora
                    </inertia-link>
                </div>
            </div>
            <DashboardTable :transportadoras="transportadoras" />
            <TablePagination :links="transportadoras.links" />
            <Modal :show="exportDialog" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Exportar Transportadoras
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Insira seu email para exportar a lista de transportadoras.
                    </p>

                    <div class="mt-6">
                        <InputLabel for="password" value="Password" class="sr-only" />
                        <TextInput
                            id="email"
                            ref="emailInput"
                            v-model="form.email"
                            type="text"
                            name="email"
                            class="mt-1 block w-full"
                            placeholder="Email"
                            @keyup.enter="sendEmail"
                        />

                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                        <PrimaryButton
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="sendEmail"
                        >
                            Exportar
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </div>

    </AuthenticatedLayout>
</template>

<script>
import DashboardTable from '@/Components/Dashboard/DashboardTable.vue';
import TablePagination from '@/Components/Dashboard/TablePagination.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    name: 'Dashboard',
    props: ['transportadoras'],
    components: {
        DashboardTable, 
        TablePagination,
        PrimaryButton,
        InputError,
        InputLabel,
        Modal,
        SecondaryButton,
        TextInput
    },
    data: () => ({
        exportDialog: false,
        form: useForm({
            email: '',
        }),
    }),
    methods: {
        closeModal(){
            this.exportDialog = false;
        },
        sendEmail(){
            this.form.post(route('transportadora.export'));
            this.exportDialog = false;
            this.form.email = '';
            alert('Email enviado com sucesso!')
        }
    }
}
</script>

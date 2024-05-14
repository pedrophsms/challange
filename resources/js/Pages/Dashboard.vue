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
                <inertia-link :href="route('transportadora.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    Adicionar Transportadora
                </inertia-link>
            </div>
            <DashboardTable :transportadoras="transportadoras" />
            <TablePagination :links="transportadoras.links" />
        </div>

    </AuthenticatedLayout>
</template>

<script>
import DashboardTable from '@/Components/Dashboard/DashboardTable.vue';
import TablePagination from '@/Components/Dashboard/TablePagination.vue';
export default {
    name: 'Dashboard',
    props: ['transportadoras'],
    components: {DashboardTable, TablePagination},
}
</script>

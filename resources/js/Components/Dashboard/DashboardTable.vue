<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border dark:border-gray-700 w-full mb-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="column in columns" :key="column.name" :class="`px-6 py-3 ${column.align}`">{{ column.name }}</th>
                </tr>
            </thead>
            <tbody>
                <TableItem v-for="transportadora in transportadoras.data" :key="transportadora.id" :transportadora="transportadora" />
            </tbody>
        </table>
    </div>
</template>

<script>
import TableItem from './TableItem.vue';
export default {
    name: 'dashboard-table',
    props: ['transportadoras'],
    components: {TableItem},
    data: () => ({
        columns: [
            { name: 'Nome', align: 'left' },
            { name: 'Localização', align: 'left' },
            { name: 'Limite de Crédito', align: 'left' },
            { name: 'Data Análise', align: 'left' },
            { name: '', align: 'right' }
        ]
    })
}
</script>
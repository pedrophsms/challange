<template>
    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ transportadora.nome }}
        </th>
        <td class="px-6 py-4">
            {{ transportadora.endereco + ', ' + transportadora.cidade + ', ' + transportadora.uf}}
        </td>
        <td class="px-6 py-4">
            {{ transportadora.limite_credito }}
        </td>
        <td class="px-6 py-4">
            {{ transportadora.data_analise_credito }}
        </td>
        <td class="px-6 py-4">
            <Dropdown>
                <template #trigger>
                    <button class="text-white focus:outline-none border border-gray-700 font-medium rounded-lg text-sm px-2.5 py-2.5 text-center inline-flex items-center dark:hover:bg-gray-700" type="button">
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                </template>
                <template #content>
                    <div class=" divide-y divide-gray-100 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                            <li>
                                <inertia-link :href="route('transportadora.edit', transportadora.uuid)" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-5 h-5 mr-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    Editar
                                </inertia-link>
                            </li>
                        </ul>
                        <div class="py-2 flex">
                            <a @click="confirmDeletion = true" class="flex cursor-pointer leading-0 items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                <svg class="w-5 h-w-5 mr-4 text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                                Excluir
                            </a>
                        </div>
                    </div>
                </template>
            </Dropdown>
            <Modal :show="confirmDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Tem certeza que quer excluir a transportadora?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Uma vez que a transportadora for excluída, todos os seus recursos e dados serão excluídos permanentemente.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': loading }"
                        :disabled="loading"
                        @click="destroy()"
                    >
                        Excluir
                    </DangerButton>
                </div>
            </div>
        </Modal>
        </td>
    </tr>
</template>
<script>
import Dropdown from '../Dropdown.vue';
import Modal from '../Modal.vue';
import DangerButton from '../DangerButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
export default {
    name: 'table-item',
    props: ['transportadora'],
    components: {Dropdown, Modal, DangerButton, SecondaryButton},
    data: () => ({
        confirmDeletion: false,
        loading: false,
    }),
    methods: {
        destroy(){
            this.loading = true;
            this.$inertia.delete(route('transportadora.destroy', this.transportadora.uuid))
            this.loading = false;
            this.confirmDeletion = false;
        },
        closeModal(){
            this.confirmDeletion = false;
        }
    }
}
</script>
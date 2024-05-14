<template>
    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-10 text-base">
            <li v-for="(link, index) in links" :key="index">
                <inertia-link 
                    v-if="index == 0" 
                    preserve-scroll 
                    :href="link.url" 
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="{'dark:bg-gray-700 text-white': link.active, 'dark:bg-gray-800 dark:text-gray-400': !link.active}"
                    >
                    <span class="sr-only">Anterior</span>
                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                </inertia-link>
                <inertia-link 
                    v-if="index > 0 && index < links.length - 1 && link.label != '...'" 
                    preserve-scroll 
                    :href="link.url" 
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700  dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="{'dark:bg-gray-700 text-white': link.active, 'dark:bg-gray-800 dark:text-gray-400': !link.active}"
                    >
                    {{ link.label }}
                </inertia-link>
                <div 
                    v-if="link.label == '...'" 
                    preserve-scroll 
                    :href="link.url" 
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700  dark:hover:bg-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white"
                    >
                    {{ link.label }}
                </div>
                <inertia-link 
                    v-if="index == links.length - 1" 
                    preserve-scroll 
                    :href="link.url" 
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="{'dark:bg-gray-700 text-white': link.active, 'dark:bg-gray-800 dark:text-gray-400': !link.active}"
                    >
                    <span class="sr-only">Próximo</span>
                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </inertia-link>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'table-pagination',
    props: ['links'],
}
</script>
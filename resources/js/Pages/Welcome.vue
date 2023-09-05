<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    users:{
        type:Object,
        default:({})
    },
    patients:{
        type:Object,
        default:({})
    },
    townships:{
        type:Object,
        default:({})
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-4">
                    <div class="min-w-sm rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800"
                        >
                        <a href="#">
                        <div class="p-4 flex items-center">
                            <div
                            class="p-3 rounded-full text-green-500 dark:text-green-100 bg-green-100 dark:bg-green-500 mr-4"
                            >
                            <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                                <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Total Accounts
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{users}}
                            </p>
                            </div>
                        </div>
                        </a>
                    </div>


                    <div class="min-w-sm rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800"
                        >
                        <a href="#">
                        <div class="p-4 flex items-center">
                            <div
                            class="p-3 rounded-full text-orange-500 dark:text-orange-100 bg-orange-100 dark:bg-orange-500 mr-4"
                            >
                            <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                                <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Total Patients
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{patients}}
                            </p>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="min-w-sm rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800"
                        >
                        <a href="#">
                        <div class="p-4 flex items-center">
                            <div
                            class="p-3 rounded-full text-blue-500 dark:text-blue-100 bg-blue-100 dark:bg-blue-500 mr-4"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>

                            </div>
                            <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                               Townships
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{townships}}
                            </p>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                
                <div class="mt-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

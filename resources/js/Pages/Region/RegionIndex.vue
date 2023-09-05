<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm,usePage, router } from '@inertiajs/vue3';
import { VueTable  } from "@harv46/vue-table";
import { ref, watch } from "vue";
import "@harv46/vue-table/dist/style.css";
import Modal from "@/Components/Modal.vue"; 
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useToast } from "vue-toastification";
import swal from 'sweetalert';
import throttle from "lodash/throttle";
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    regions:{
        type:Object,
        default:({})
    },
    roles:{
        type:Object,
        default:({})
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

let search = ref(props.filters.search);
const toast = useToast();
const addNewPopUp = ref(false)
const header = ["ID", "Name"]
const keys=["id","name"]

const data = props.regions;

const form = useForm({
    name: '',
    terms: false,
});

watch(search, throttle((value) => {
    router.get(
        "/basic-data/region",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 1000));

const createForm = () => {
    form.post('/basic-data/region', {
        preserveScroll: true,
        onSuccess: () => {
            addNewPopUp.value = false
            form.reset()
            form.clearErrors()
           
            toast.info("State/Region was created successfully", {
                timeout: 3000
            });
        },
        onError:() => {
            toast.error("Something was wrong please try again", {
                timeout: 4000
            })
            }
    });
}

const deleteForm = (id) => {
    swal({
        title: "Are you sure?",
        text: "Once deleted, You won't be able to recover this data",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            form.delete(route('region.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    location.reload()
                }
            })
        }
    });
}

</script>

<template>
    <Head title="Region" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-5 gap-1">
                <div class="col-span-3 md:col-span-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">State/Region</h2>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <button  @click="addNewPopUp = true" class=" inline-flex text-sm bg-blue-500 w-fit mr-3 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add
                    </button>
                  
                </div>
               
            </div>
           
        </template>
        <!-- add pop up -->
            <Modal :show="addNewPopUp" @close="addNewPopUp = false">
                <div class="bg-white drop-shadow-lg py-2 md:px-4 
                px-2 rounded-md sm:h-auto h-[340px] sm:overflow-auto overflow-y-scroll" id="popup" v-show="addNewPopUp">
                   
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="md:text-base font-medium text-md">Add New State/Region</h2>
                            <span class="bg-red-400 px-2 py-1 shadow-sm rounded-md cursor-pointer"
                            @click="addNewPopUp = false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                        </div>
                <form @submit="createForm" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex items-center justify-start mt-4">
                    
                        <button
                            :type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >Add
                        </button>
                    </div>
                </form>
                </div>
            </Modal>
        <!-- end add pop up -->

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">  
                <div class="flex inflex-flex">
               
                    <div class="mx-0 relative md:w-1/3 w-1/3 mb-3">
                        <TextInput id="search" type="text" v-model="search" 
                        class="w-full px-5 py-2 block w-md text-gray-500 
                            text-sm  bg-white focus:ring-blue-500 
                            focus:border-blue-500 " placeholder="Search by District Name"/>
                    
                    </div>
                   
                 </div> 
            
                <div class="relative overflow-x-auto">
                    <table class=" shadow-lg rounded-lg px-4 py-4 w-full text-sm md:text-sm text-left bg-white text-gray-800 
                    border-collapse">
                        <thead class="text-xs text-gray-800 uppercase bg-gray-50 ">
                            <tr class="bg-main font-semibold">
                                <th scope="col" class="px-1 py-2  border border-gray-300">
                                    No
                                </th>
                                <th scope="col" class="px-1 py-2  border border-gray-300">
                                Name
                                </th>
                                <th scope="col" class="px-1 py-2  border border-gray-300">
                                Actions
                                </th>


                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(c,i) in regions.data">
                                <td class="text-center px-1 py-2 capitalize border border-gray-300">
                                    {{ Number(i) + 1 }}
                                </td>

                                <td class="text-left px-1 py-2 capitalize border border-gray-300">
                                    {{ c.name }}
                                </td>
                                <td class="text-left px-1 py-2 border border-gray-300">
                                    <div class="mt-2">
                                        <Link title="Edit" :href="route('region.edit',c.id)" class=" inline-flex text-sm bg-green-500 w-fit mr-3 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </Link>
                                        <button @click="deleteForm(c.id)" title="Delete" class="bg-red-500 text-sm w-fit hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                
                            </tr>

                        </tbody>
                    </table>
                </div>
                <Pagination class="mt-3" :links="props.regions.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

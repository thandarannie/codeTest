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
import "vue-toastification/dist/index.css";

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    users:{
        type:Object,
        default:({})
    },
    roles:{
        type:Object,
        default:({})
    }
});
const toast = useToast();
const addNewPopUp = ref(false)
const header = ["ID", "Name","Email",'Role']
const keys=["id","name", "email",'role']

const data = props.users;

const form = useForm({
    name: '',
    email: '',
    password: '',
    role:'',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('user.register'), {
        preserveScroll: true,
        onSuccess: () => {

            form.reset()
            form.clearErrors()
            addNewPopUp.value = false

            toast.info("New user added successfully", {
                timeout: 3000
            });
        }
    });
};
</script>

<template>
    <Head title="User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-5 gap-1">
                <div class="col-span-3 md:col-span-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <button  @click="addNewPopUp = true" class=" inline-flex text-sm bg-blue-500 w-fit mr-3 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add
                    </button>
                    <button class="inline-flex bg-red-500 text-sm w-fit hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                        </svg>
                        Export
                    </button>
                </div>
               
            </div>
           
        </template>
<!-- add new customer pop up -->
<Modal :show="addNewPopUp" @close="addNewPopUp = false">
            <div class="bg-white drop-shadow-lg py-2 md:px-4 
            px-2 rounded-md sm:h-auto h-[340px] sm:overflow-auto overflow-y-scroll" id="popup" v-show="addNewPopUp">
                <form @submit.prevent="createNewCustomer">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="md:text-base font-medium text-md">Add New User</h2>
                        <span class="bg-red-400 px-2 py-1 shadow-sm rounded-md cursor-pointer"
                        @click="addNewPopUp = false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                    </div>
                </form>
            <form @submit.prevent="submit">
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

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-4">
                <InputLabel for="role" value="Role (Required)" />
                <div  class="flex gap-2 mt-1 w-full items-center sm:text-sm text-xs">
                    <div v-for="r in roles" class="flex gap-1 items-center">
                        <TextInput  type="radio" :value="r.id" v-model="form.role" name="role"></TextInput>
                        <span>{{r.name}}</span>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.role" />
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
            
                <button
                    :type="type" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >Register
                </button>
            </div>
        </form>
            </div>
        </Modal>
        <!-- end add new customer pop up -->


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">      
                <div>
                    <VueTable :headers="header" :data="data" :keys="keys" >
                        <template #th>
                            <th> Actions</th>
                        </template>
                        <template #td="{ item }">
                            <td class="flex">
                                <!-- <DeleteIcon @click="deleteItem(item.id)" />
                                <EditIcon @click="edit(item)" /> -->
                                
                                    <button class=" inline-flex text-sm bg-green-500 w-fit mr-3 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
                                        Update
                                    </button>
                                    <button class="bg-red-500 text-sm w-fit hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>

                                    </button>
                                
                            </td>
                        </template>
                    </VueTable>
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

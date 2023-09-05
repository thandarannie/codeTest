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
    regions:{
        type:Object,
        default:({})
    },
    district:{
        type:Object,
        default:({})
    }
});
const toast = useToast();

const form = useForm({
    name:props.district.name,
    region_id:props.district.region_id,
});

const updateForm = () => {

form.put('/basic-data/district/update/'+ props.district.id,{
    preserveScroll: true,
    onSuccess: () => {
            
            form.reset()
            form.clearErrors()
           
            toast.info("District was updated successfully", {
                timeout: 3000
            });
        },
});

}

const goBack = () => {
        window.history.back()
    }
</script>

<template>
    <Head title="District" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-5 gap-1">
                <div class="col-span-3 md:col-span-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">District Edit</h2>
                </div>
                <div class="col-span-2 md:col-span-1 justify-end">
                    <button  @click="goBack" class=" inline-flex text-sm bg-blue-500 w-fit mr-3 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                        </svg>
                        Back
                    </button>
                   
                </div>
               
            </div>
           
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="updateForm">
                    <div>
                        <InputLabel for="region" value="Region" />

                        <div >
                            <select v-model="form.region_id" class="w-1/2
                             px-5 py-2 block w-md text-gray-500 
                                text-sm  border border-gray-400 bg-white
                                focus:ring-blue-500 focus:border-blue-500 " 
                                style="border-radius: 4px;border: 1px solid #ddd" required> 
                                <option value="" disabled selected>Select State/Region</option>  
                                <option v-for="c in regions" :value="c.id">{{ c.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div  class="mt-2">
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-1/2"
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
                        >Update
                        </button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
   
    </AuthenticatedLayout>
</template>

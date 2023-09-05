<script setup>
import {Link} from '@inertiajs/vue3';
const props = defineProps({
    links: {
        type: Array
    }
})

</script>
<template>
    <div v-if="props.links.length > 3" class="flex justify-center items-center">
        <div class="flex flex-wrap items-center">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 md:px-4 px-2 md:py-3 py-1.5 text-sm leading-4 
                text-gray-400 border rounded"
                    v-html="link.label" />
                <Link v-else
                    class="mr-1 mb-1 md:px-4 px-2 md:py-3 py-1.5 text-sm leading-4 border rounded cursor-pointer 
                    focus:border-main focus:text-gray-300"
                    :class="{ 'bg-gray-50 text-gray': link.active }" :href="link.url" v-html="link.label">
                </Link>
            </template>
        </div>
    </div>
</template>
<script setup>
    const props = defineProps(['flash']);

    function close() {
        props.flash.success = null;
        props.flash.error = null;
    }
</script>

<template>
    <div
        :class="{
            'bg-green-100 border border-green-400 text-green-700': flash.success,
            'bg-red-100 border border-red-400 text-red-700': flash.error
        }"
        class="relative px-4 py-3 mb-6 rounded"
        role="alert"
    >
        <div v-if="flash.success">
            <strong class="font-bold">Success: </strong>
            <span class="block sm:inline">{{ flash.success }}</span>
        </div>

        <div v-if="flash.error">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline">{{ flash.error }}</span>
        </div>

        <span
            class="absolute top-0 bottom-0 right-0 px-4 py-3"
            @click="close"
        >
            <svg
                class="w-6 h-6 text-red-500 fill-current"
                :class="{
                    'text-green-500': flash.success,
                    'text-red-500': flash.error
                }"
                role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps(['links'])
</script>

<template>
    <div class="space-x-2">
        <template v-for="link in links">
            <Link
                v-if="link.url"
                :href="link.url"
                class="bg-gray-50 border border-gray-200 px-3 py-2 rounded-md hover:bg-gray-200 disabled:bg-gray-200"
                as="button"
                :disabled="link.active"
                v-html="link.label"
            />
            <span
                v-else
                v-html="link.label"
                class="border border-gray-200 px-3 py-2 rounded-md bg-gray-200"
            />
        </template>
    </div>
</template>

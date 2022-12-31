<script setup>
import { ref, watch } from 'vue';
import ProjectsList from '@/Components/Projects/ProjectsList.vue';
import CreateProject from '@/Components/Projects/CreateProject.vue';
import Pagination from '@/Shared/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import debounce from 'lodash/debounce';

let props = defineProps(['projects', 'filters']);

let search = ref(props.filters['search'] ?? '');

watch(search, debounce(function(value) {
    Inertia.get(
        route('projects.index'),
        {
            filters: {
                search: value
            }
        },
        {
            preserveState: true,
            replace: true
        }
    )
}, 500))
</script>

<template>
    <div class="flex justify-between mb-6">
        <CreateProject />
        <input type="text" name="search" v-model="search" class="border border-gray-500 placeholder:text-gray-500 rounded-lg p-2 w-1/4 outline-blue-500" placeholder="Search...">
    </div>
    <ProjectsList :projects="projects.data" />

    <Pagination :links="projects.links" class="mt-4" />
</template>

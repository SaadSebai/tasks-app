<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import EditProject from '@/Components/Projects/EditProject.vue';
import DeleteProject from '@/Components/Projects/DeleteProject.vue';
import { Inertia } from '@inertiajs/inertia';

dayjs.extend(relativeTime);

defineProps(['projects']);

function toTasks (projectId) {
    Inertia.get(route('projects.tasks.index', projectId));
}
</script>

<template>
    <div class="overflow-hidden">
        <table class="border table-fixed">
            <thead class="bg-gray-200 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Tasks N°
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Started at
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Finished at
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Created at
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="project in projects" class="transition duration-300 ease-in-out bg-white border-b hover:bg-gray-100" :key="project.id" @dblclick="toTasks(project.id)">
                    <td class="px-6 py-4 text-sm font-light text-gray-900">
                        {{ project.name }}
                    </td>
                    <td class="px-6 py-4 text-sm font-light text-gray-900">
                        {{ project.description }}
                    </td>
                    <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
                        {{ project.tasks_count }}
                    </td>
                    <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
                        {{ project.started_at ? dayjs(project.started_at).fromNow() : '---' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
                        {{ project.finished_at ? dayjs(project.finished_at).fromNow() : '---' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
                        {{ project.created_at ? dayjs(project.created_at).fromNow() : '---' }}
                    </td>
                    <td class="px-6 py-4 space-x-3 text-sm whitespace-nowrap">
                        <EditProject :project="project" />
                        <DeleteProject :project="project" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

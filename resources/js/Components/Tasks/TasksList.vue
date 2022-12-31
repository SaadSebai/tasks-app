<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import Task from '@/Components/Tasks/Task.vue';

let props = defineProps(['tasks', 'showLoad']);

</script>

<template>
    <div class="overflow-hidden">
        <table class="w-full border table-fixed">
            <thead class="bg-gray-200 border-b">
                <tr>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Preority
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Progression
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Estimated duration
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Deadline
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Started At
                    </th>
                    <th scope="col" class="px-6 py-4 text-sm font-medium text-left text-gray-900 whitespace-nowrap">
                        Finished At
                    </th>
                </tr>
            </thead>
            <tbody>
                <Task v-for="task in tasks" :key="task.id" :task="task" @update:task="updateList(task)" @task-delete="$emit('task-delete', task)" />
            </tbody>
        </table>
        <div v-show="showLoad && tasks.length > 0" class="grid p-1 text-sm text-blue-500 bg-gray-100 border-b justify-items-center border-x hover:text-blue-600 hover:bg-gray-200">
            <Link as="button" class="w-full text-center" @click="$emit('load')" preserve-scroll>load...</Link>
        </div>
    </div>
</template>

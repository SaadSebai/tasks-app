<script setup>
import { inject } from 'vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

let project = inject('project');

</script>

<template>
    <div class="border border-gray-200 rounded-md text-gray-600 shadow-md py-5 px-10 space-y-4">
        <div>
            <span class="text-gray-700 font-bold">Name:</span> {{ project.name }}
        </div>
        <div>
            <span class="text-gray-700 font-bold">Description:</span> {{ project.description }}
        </div>
        <div class="flex space-x-14">
            <div>
                <span class="text-gray-700 font-bold">Started at:</span> {{ project.started_at ? dayjs(project.started_at).format('YYYY-MM-DD HH:mm') : '---' }}
            </div>
            <div>
                <span class="text-gray-700 font-bold">Finished at:</span> {{ project.finished_at ? dayjs(project.finished_at).format('YYYY-MM-DD HH:mm') : '---' }}
            </div>
            <div>
                <span class="text-gray-700 font-bold">Created at:</span> {{ project.created_at ? dayjs(project.created_at).format('YYYY-MM-DD HH:mm') : '---' }}
            </div>
        </div>
        <div class="flex space-x-14">
            <div>
                <span class="text-gray-700 font-bold">To do:</span> {{ project.tasks_to_do_count }}
            </div>
            <div class="text-blue-500">
                <span class="text-gray-700 font-bold">In Progress:</span> {{ project.tasks_in_progress_count }}
            </div>
            <div class="text-yellow-500">
                <span class="text-gray-700 font-bold">On Hold:</span> {{ project.tasks_on_hold_count }}
            </div>
            <div class="text-amber-800">
                <span class="text-gray-700 font-bold">In Test:</span> {{ project.tasks_in_test_count }}
            </div>
            <div class="text-green-500">
                <span class="text-gray-700 font-bold">Done:</span> {{ project.tasks_done_count }}
            </div>
            <div class="text-red-500">
                <span class="text-gray-700 font-bold">Canceled:</span> {{ project.tasks_canceled_count }}
            </div>
        </div>
    </div>
</template>

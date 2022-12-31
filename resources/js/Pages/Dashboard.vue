<script setup>
import TasksStatuses from '@/Components/Charts/TasksStatuses.vue';
import TasksPriorities from '@/Components/Charts/TasksPriorities.vue';

defineProps(['tasks_statuses', 'tasks_priorities']);

</script>

<template>
    <div class="w-full bg-gray-200 ">
        <div class="flex">
            <div>
                <TasksStatuses :tasks_statuses="tasks_statuses" />
            </div>
            <div>
                <TasksPriorities :tasks_priorities="tasks_priorities" />
            </div>
        </div>
    </div>
</template>

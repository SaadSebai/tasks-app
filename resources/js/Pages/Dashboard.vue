<script setup>
import TasksStatuses from '@/Components/Charts/TasksStatuses.vue';
import TasksPriorities from '@/Components/Charts/TasksPriorities.vue';
import TasksDeadlines from '@/Components/Charts/TasksDeadlines.vue';

defineProps(['tasks_statuses', 'tasks_priorities', 'tasks_deadlines']);

</script>

<template>
    <div class="w-full bg-gray-200 ">
        <div class="flex p-3 space-x-4 text-xl font-semibold text-center">
            <div class="space-y-2">
                <h1>Tasks Statuses</h1>
                <TasksStatuses :tasks_statuses="tasks_statuses" />
            </div>
            <div class="space-y-2">
                <h1>Tasks Priorities</h1>
                <TasksPriorities :tasks_priorities="tasks_priorities" />
            </div>
            <div class="space-y-2">
                <h1>Tasks Deadlines</h1>
                <TasksDeadlines :tasks_deadlines="tasks_deadlines" />
            </div>
        </div>
    </div>
</template>

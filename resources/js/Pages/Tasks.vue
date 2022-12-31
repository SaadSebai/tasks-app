<script setup>
import TasksList from '@/Components/Tasks/TasksList.vue';
import { Inertia } from '@inertiajs/inertia';
import { ref, watch, provide } from 'vue';
import debounce from 'lodash/debounce';
import CreateTask from '@/Components/Tasks/CreateTask.vue';
import ProjectDetails from '@/Components/Projects/ProjectDetails.vue';
import { usePage } from '@inertiajs/inertia-vue3';

let props = defineProps(['tasks', 'project', 'filters']);

let allTasks = ref(props.tasks.data);
let initialUrl = ref(usePage().url.value);
let showLoad = ref(props.tasks.next_page_url);

let search = ref(props?.filters['search'] ?? '');
let selected_status = ref(props?.filters['status'] ?? '');

provide('project', props.project);

watch(search, debounce(function(value) {
    filter(value, selected_status.value);
}, 500))

/**
 * Filter by tasks's status
 * @param {String} value
 */
function filterByStatus(value) {
    selected_status.value != value
        ? selected_status.value = value
        : selected_status.value = value = null;
    filter(search.value, value);
}

/**
 * Send a request to filter records
 * @param {String} search
 * @param {String} status
 */
function filter(search, status) {
    Inertia.get(
        route('projects.tasks.index', props.project.id),
        {
            filters: {
                search: search,
                status: status
            }
        },
        {
            preserveState: true,
            replace: true,
            onSuccess: () => {
                allTasks.value  = props.tasks.data;
                showLoad.value  = props.tasks.next_page_url;
            }
        }
    )
}

/**
 * Load next page data
 * @param {String} title
 */
function load(title) {
    if (props.tasks.next_page_url === null) {
        return
    }

    Inertia.get(props.tasks.next_page_url, {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
    only: ['tasks'],
    onSuccess: () => {
        initialUrl.value ??= url;
        allTasks.value = [...allTasks.value, ...props.tasks.data];
        window.history.replaceState({}, title, initialUrl.value);
        showLoad.value = props.tasks.next_page_url;
    }
    })
}

function addNewTask() {
    allTasks.value.unshift(usePage().props.value.returned_data.task)
}

/**
 * Remove task from list
 * @param {*} task
 */
function removeTask(task) {
    allTasks.value = allTasks.value.filter(value => value.id !== task.id);
}
</script>

<template>
    <ProjectDetails class="mb-6" />

    <div class="flex justify-between mb-6">
        <CreateTask @task-created="addNewTask" />
        <div class="flex items-center">
            <div class="space-x-1">
                <button
                    v-for="status in $page.props.tasks_enums.statuses"
                    class="p-1 text-sm text-gray-100 rounded-lg"
                    :class="{
                        'bg-red-500': (status == selected_status),
                        'bg-gray-400': (status != selected_status)
                    }"
                    @click="filterByStatus(status)"
                    preserve-scroll
                >
                    {{ status + ( status == selected_status ? ' X' : '' ) }}
                </button>
            </div>
        </div>
        <input type="text" name="search" v-model="search" class="w-1/4 p-2 border border-gray-500 rounded-lg placeholder:text-gray-500 outline-blue-500" placeholder="Search...">
    </div>

    <TasksList :tasks="allTasks" :showLoad="showLoad" @load="load($page.url, $page.title)" @task-delete="removeTask" />
</template>

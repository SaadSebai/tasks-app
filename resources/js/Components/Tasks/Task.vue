<script setup>
import { ref, computed, inject } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import ShowModal from '@/Shared/ShowModal.vue';
import InputError from '@/Shared/InputError.vue';
import ConfirmationModal from '@/Shared/ConfirmationModal.vue';
import { Inertia } from '@inertiajs/inertia';

dayjs.extend(relativeTime);

let props = defineProps(['task']);

let emit = defineEmits(['task-delete']);

let show = ref(false);

let showDelete = ref(false);

let url = ref(usePage().url.value)

let project = inject('project');

/**
 * Change color of priority based on value (low , medium, high)
 */
const priorityColor = computed(() => {
    let color = 0;

    usePage().props.value.tasks_enums.priorities.forEach((element, index) => {
        if(props.task.priority === element) color = index;
    });

    return color;
});

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    status: props.task.status,
    priority: props.task.priority,
    estimated_duration: props.task.estimated_duration,
    estimation_type: props.task.estimation_type,
    deadline: props.task.deadline ? dayjs(props.task.deadline).format('YYYY-MM-DD HH:mm') : '',
    started_at: props.task.started_at ? dayjs(props.task.started_at).format('YYYY-MM-DD HH:mm') : '',
    finished_at: props.task.finished_at ? dayjs(props.task.finished_at).format('YYYY-MM-DD HH:mm') : '',
    progression: props.task.progression
});


/**
 * Send request to update task
 */
function submit() {
    form.put(
        route('projects.tasks.update', {'project': project.id, 'task': props.task.id}),
        {
            onSuccess: () => {
                window.history.replaceState({}, {}, url.value);
                show.value = false

                props.task.title = form.title
                props.task.description = form.description
                props.task.status = form.status
                props.task.priority = form.priority
                props.task.estimated_duration = form.estimated_duration
                props.task.estimation_type = form.estimation_type
                props.task.deadline = form.deadline
                props.task.started_at = form.started_at
                props.task.finished_at = form.finished_at
                props.task.progression = form.progression
            },
            preserveScroll: true
        }
    );
}

/**
 * Delete task
 */
function destory() {
    Inertia.delete(
        route('projects.tasks.destroy', {'project': project.id, 'task': props.task.id}),
        {
            onSuccess: () => {
                showDelete.value = false;
                show.value = false;
                emit('task-delete');
            }
        }
    );
}
</script>
<template>
    <!-- Table Element -->
    <tr class="transition duration-300 ease-in-out bg-white border-b hover:bg-gray-100" @dblclick="show = true">
        <td class="px-6 py-4 text-sm font-light text-gray-900">
            {{ task.title }}
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900">
            {{ task.status }}
        </td>
        <td class="px-6 py-4 text-sm whitespace-nowrap" :class="{
                    'text-yellow-500': priorityColor === 0,
                    'text-orange-500': priorityColor === 1,
                    'text-red-600': priorityColor === 2
                }">
            {{ task.priority }}
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full " :style="{ width: `${task.progression}%` }"></div>
            </div>
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
            {{ task.estimation_type ?  `${task.estimated_duration}  ${task.estimation_type}` : '---' }}
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
            {{ task.deadline ? dayjs(task.deadline).format('YYYY-MM-DD HH:mm') : '---' }}
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
            {{ task.started_at ? dayjs(task.started_at).fromNow() : '---' }}
        </td>
        <td class="px-6 py-4 text-sm font-light text-gray-900 whitespace-nowrap">
            {{ task.finished_at ? dayjs(task.finished_at).fromNow() : '---' }}
        </td>
    </tr>

    <!-- Show/Edit form -->
    <ShowModal v-show="show" @hide="show = false">
        <form @submit.prevent="submit">
            <div class="mb-6 text-4xl font-semibold">
                <input type="text" name="title" id="title" v-model="form.title" class="w-full h-full px-2 py-1 rounded-lg focus:outline focus:outline-1 focus:outline-blue-300">
                <InputError :message="form.errors.title" />
            </div>
            <div class="flex justify-between">
                <div class="w-full pr-5 text-xl">
                    <textarea name="description" id="description" v-model="form.description" class="w-full h-full px-2 py-1 rounded-lg focus:outline focus:outline-1 focus:outline-blue-300"></textarea>
                    <InputError :message="form.errors.description" />
                </div>
                <div class="w-1/2 pl-2 space-y-4 text-lg">
                    <div class="">
                        <select v-model="form.status" name="status" id="status" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                            <option v-for="status in $page.props.tasks_enums.statuses" :value="status">{{ status }}</option>
                        </select>
                        <InputError :message="form.errors.status" />
                    </div>
                    <div>
                        <select v-model="form.priority" name="priority" id="priority" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                            <option v-for="priority in $page.props.tasks_enums.priorities" :value="priority">{{ priority }}</option>
                        </select>
                        <InputError :message="form.errors.priority" />
                    </div>
                    <div>
                        <div class="flex space-x-4">
                            <span id="progression">Progression:</span>
                            <input type="range" min="0" max="100" name="progression" id="progression" v-model="form.progression" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                            <p>
                                {{ form.progression }}%
                            </p>
                        </div>
                        <InputError :message="form.errors.progression" />
                    </div>
                    <div class="flex justify-between space-x-2">
                        <input type="number" min="0" name="estimated_duration" id="estimated_duration" v-model="form.estimated_duration" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                        <InputError :message="form.errors.estimated_duration" />
                        <select v-model="form.estimation_type" name="estimation_type" id="estimation_type" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                            <option v-for="estimation_type in $page.props.tasks_enums.estimation_type" :value="estimation_type">{{ estimation_type }}</option>
                        </select>
                        <InputError :message="form.errors.estimation_type" />
                    </div>
                    <div>
                        <div class="flex justify-between space-x-4">
                            <span>Deadline:</span>
                            <input type="datetime-local" name="deadline" id="deadline" v-model="form.deadline" class="w-2/3 px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                        </div>
                        <InputError :message="form.errors.deadline" />
                    </div>
                    <div>
                        <div class="flex justify-between space-x-4 whitespace-nowrap">
                            <span class="">Start Date:</span>
                            <input type="datetime-local" name="started_at" id="started_at" v-model="form.started_at" class="w-2/3 px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                        </div>
                        <InputError :message="form.errors.started_at" />
                    </div>
                    <div>
                        <div class="flex justify-between space-x-4 whitespace-nowrap">
                            <span>Finish Date:</span>
                            <input type="datetime-local" name="finished_at" id="finished_at" v-model="form.finished_at" class="w-2/3 px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                        </div>
                        <InputError :message="form.errors.finished_at" />
                    </div>
                </div>
            </div>
            <div class="flex flex-row-reverse w-full px-8 py-4 mt-10 border-t">
                <button
                    type="submit"
                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm focus:outline-none sm:ml-3 sm:w-auto"
                    :class="{
                        'bg-blue-500 hover:bg-blue-600': form.isDirty,
                        'bg-gray-300': !form.isDirty
                    }"
                    :disabled="!form.isDirty"
                >
                    Update
                </button>
                <button
                    @click="showDelete = true"
                    type="button"
                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-500 border border-transparent rounded-md shadow-sm hover:bg-red-600 focus:outline-none sm:ml-3 sm:w-auto"
                >
                    Delete
                </button>
            </div>
        </form>
        <ConfirmationModal v-if="showDelete" @hide="showDelete = false" @confirm="destory" preserve-scroll>
            <template #title>
                Deleting Task
            </template>

            <div>
                Are you sure you want to delete this task
            </div>
        </ConfirmationModal>
    </ShowModal>
</template>

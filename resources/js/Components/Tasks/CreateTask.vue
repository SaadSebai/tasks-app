<script setup>
import { ref, inject } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import FormModal from '@/Shared/FormModal.vue';
import InputError from '@/Shared/InputError.vue';

let emit = defineEmits(['task-created']);

let show = ref(false)

let url = ref(usePage().url.value)

let project = inject('project');

const form = useForm({
    title: '',
    description: '',
    status: usePage().props.value.tasks_enums.statuses[0],
    priority: usePage().props.value.tasks_enums.priorities[0],
    estimated_duration: 0,
    estimation_type: usePage().props.value.tasks_enums.estimation_type[0],
    deadline: '',
    started_at: '',
    finished_at: '',
    progression: 0
});

function submit() {
    form.post(
        route('projects.tasks.store', project.id),
        {
            onSuccess: () => {
                form.reset();
                window.history.replaceState({}, {}, url.value);
                show.value = false;
                emit('task-created');
            }
        }
    );
}
</script>

<template>
    <button
        class="px-3 py-2 text-gray-100 bg-green-600 rounded-lg hover:bg-green-800"
        @click="show = !show"
    >
        Create Task
    </button>
    <FormModal v-if="show" class="mt-2" @hide="show = false" :action="submit" :form="form">
        <div class="w-full space-y-3">
            <div>
                <span for="title">Title: </span>
                <input type="text" name="title" id="title" v-model="form.title" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                <InputError :message="form.errors.title" />
            </div>
            <div>
                <span for="description">Description: </span>
                <textarea name="description" id="description" v-model="form.description" cols="30" rows="3" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300"></textarea>
                <InputError :message="form.errors.description" />
            </div>
            <div>
                <span for="status">Status: </span>
                <select v-model="form.status" name="status" id="status" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                    <option v-for="status in $page.props.tasks_enums.statuses" :value="status">{{ status }}</option>
                </select>
                <InputError :message="form.errors.status" />
            </div>
            <div>
                <span for="priority">Priority: </span>
                <select v-model="form.priority" name="priority" id="priority" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                    <option v-for="priority in $page.props.tasks_enums.priorities" :value="priority">{{ priority }}</option>
                </select>
                <InputError :message="form.errors.priority" />
            </div>
            <div>
                <span for="progression">Progression(%): </span>
                <div class="flex space-x-2">
                    <input type="range" min="0" max="100" name="progression" id="progression" v-model="form.progression" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                    <input type="number" min="0" max="100" v-model="form.progression" class="px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                </div>
                <InputError :message="form.errors.progression" />
            </div>
            <div>
                <span for="estimated_duration">Estimated duration: </span>
                <input type="number" min="0" name="estimated_duration" id="estimated_duration" v-model="form.estimated_duration" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                <InputError :message="form.errors.estimated_duration" />
            </div>
            <div>
                <span for="estimation_type">Estimation type: </span>
                <select v-model="form.estimation_type" name="estimation_type" id="estimation_type" class="w-full px-2 py-1 capitalize border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                    <option v-for="estimation_type in $page.props.tasks_enums.estimation_type" :value="estimation_type">{{ estimation_type }}</option>
                </select>
                <InputError :message="form.errors.estimation_type" />
            </div>
            <div>
                <span for="deadline">Deadline: </span>
                <input type="datetime-local" name="deadline" id="deadline" v-model="form.deadline" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                <InputError :message="form.errors.deadline" />
            </div>
            <div>
                <span for="started_at">Start Date: </span>
                <input type="datetime-local" name="started_at" id="started_at" v-model="form.started_at" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                <InputError :message="form.errors.started_at" />
            </div>
            <div>
                <span for="finished_at">Finish Date: </span>
                <input type="datetime-local" name="finished_at" id="finished_at" v-model="form.finished_at" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                <InputError :message="form.errors.finished_at" />
            </div>
        </div>
    </FormModal>
</template>

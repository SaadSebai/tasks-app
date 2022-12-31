<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import FormModal from '@/Shared/FormModal.vue';
import InputError from '@/Shared/InputError.vue';

dayjs.extend(relativeTime);

let props = defineProps(['project'])

let show = ref(false)

const form = useForm({
    name: props.project.name,
    description: props.project.description,
    started_at: dayjs(props.project.started_at).format('YYYY-MM-DD HH:mm'),
    finished_at: dayjs(props.project.finished_at).format('YYYY-MM-DD HH:mm')
});

function submit() {
    form.put(
        route('projects.update', props.project.id),
        {
            onSuccess: () => {
                show.value = false
            },
            preserveScroll: true
        }
    );
}
</script>

<template>
    <button
        class="text-orange-300 hover:text-orange-500"
        @click="show = !show"
    >
        Edit
    </button>
    <Teleport to="body">
        <FormModal v-if="show" class="mt-2" @hide="show = false" :action="submit" :form="form">
            <div class="w-full space-y-3">
                <div>
                    <span for="name">Name: </span>
                    <input type="text" name="name" id="name" v-model="form.name" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300">
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <span for="description">Description: </span>
                    <textarea name="description" id="description" v-model="form.description" cols="30" rows="3" class="w-full px-2 py-1 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-300"></textarea>
                    <InputError :message="form.errors.description" />
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
    </Teleport>
</template>

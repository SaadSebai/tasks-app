<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import FormModal from '@/Shared/FormModal.vue';
import InputError from '@/Shared/InputError.vue';

let show = ref(false)

const form = useForm({
    name: '',
    description: '',
    started_at: '',
    finished_at: '',
});

function submit() {
    form.post(
        route('projects.store'),
        {
            onSuccess: () => {
                form.reset(),
                show.value = false
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
        Create Project
    </button>
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
</template>

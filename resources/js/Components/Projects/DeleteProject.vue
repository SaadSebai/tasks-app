<script setup>
import { ref } from 'vue';
import ConfirmationModal from '@/Shared/ConfirmationModal.vue';
import { Inertia } from '@inertiajs/inertia';

let props = defineProps(['project'])
let show = ref(false)

function destory() {
    Inertia.delete(route('projects.destroy', props.project.id));
    show.value = false;
}

</script>
<template>
    <button
        class="text-red-500 hover:text-red-700"
        @click="show = !show"
    >
        Delete
    </button>

    <ConfirmationModal v-if="show" @hide="show = false" @confirm="destory">
        <template #title>
            Deleting Project
        </template>

        <div>
            Are you sure you want to delete this project
        </div>
    </ConfirmationModal>
</template>

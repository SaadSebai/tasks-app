<script setup>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { ref, computed } from 'vue';
import collect from 'collect.js';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

let props = defineProps(['tasks_priorities']);

const priorities = computed(() => {
    return collect(props.tasks_priorities).sort().pluck('priority').toArray();
});

const rates = computed(() => {
    return collect(props.tasks_priorities).sort().pluck('count').toArray();
});

let data = ref({
    labels: priorities,
    datasets: [
        {
            label: 'Tasks Priorities',
            backgroundColor: ['crimson', 'gold', 'chocolate'],
            data: rates
        }
    ]
});

let options = ref({
    responsive: true,
    maintainAspectRatio: false
});

</script>

<template>
    <div class="h-80">
        <Bar
            :options="options"
            :data="data"
        />
    </div>
</template>

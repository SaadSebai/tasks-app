<script setup>
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js';
import { ref, computed } from 'vue';
import collect from 'collect.js';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

let props = defineProps(['tasks_deadlines']);

console.log(props.tasks_deadlines);
const days = computed(() => {
    return collect(props.tasks_deadlines).pluck('end_date').toArray();
});

const rates = computed(() => {
    return collect(props.tasks_deadlines).pluck('count').toArray();
});

let data = ref({
    labels: days,
    datasets: [
        {
            label: 'Tasks Deadlines',
            backgroundColor: 'crimson',
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
        <Line
            :options="options"
            :data="data"
        />
    </div>
</template>

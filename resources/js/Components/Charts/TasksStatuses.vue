<script setup>
import { ref, computed } from 'vue';
import { Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import collect from 'collect.js';

ChartJS.register(ArcElement, Tooltip, Legend);

let props = defineProps(['tasks_statuses']);

// Computed
const statuses = computed(() => {
    return collect(props.tasks_statuses).sort().pluck('status').toArray();
});

const rates = computed(() => {
    let counts = collect(props.tasks_statuses).sort().pluck('count');
    let sum = counts.sum();

    return counts.map(item => (item * 100) /sum).toArray();
});

const colors = computed(() => {
    let general_colors = ['crimson', 'forestgreen', 'dodgerblue', 'chocolate', 'gold', 'darkgrey', 'purple', 'blue', 'orange', 'pink', 'black']
    return collect().times(rates.value.length, number => general_colors[number - 1]).toArray();
});

let data = ref({
    labels: statuses,
    datasets: [
        {
            backgroundColor: colors,
            data: rates
        }
    ]
});

let options = ref({
    responsive: true,
    maintainAspectRatio: false
})
</script>

<template>
    <div class="h-80">
        <Doughnut
            :data="data"
            :options="options"
        />
    </div>
</template>

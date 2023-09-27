<template>
    <Doughnut id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>
  
<script>
import { Doughnut } from 'vue-chartjs'
export default {
    components: { Doughnut },
    data() {
        return {
            chartData: {
                labels: ['Cumplido', 'Sin Cumplir'],
                datasets: [
                    {
                        data: [80, 20],
                        backgroundColor: ['#71dd37 ', '#d9dee3'], // Colores personalizados
                        borderColor: 'white',
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                rotation: -90,
                circumference: 180,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    // tooltip: {
                    //     callbacks: {
                    //         label: function (context) {
                    //             var label = context.label || '';
                    //             var value = context.formattedValue || '';
                    //             var percentage = context.raw * 100 + '%';
                    //             return label + ': ' + value + ' (' + percentage + ')';
                    //         },
                    //     },
                    // },
                    datalabels: {
                        backgroundColor: function (context) {
                            return context.dataset.backgroundColor;
                        },
                        borderColor: 'white',
                        borderRadius: 25,
                        borderWidth: 2,
                        color: 'white',
                        display: function (context) {
                            var dataset = context.dataset;
                            var count = dataset.data.length;
                            var value = dataset.data[context.dataIndex];
                            return value > count * 1.5;
                        },
                        font: {
                            weight: 'bold',
                            size: 16, // Ajusta el tamaño del número de las etiquetas aquí
                        },
                        padding: 6,
                        formatter: function (value, context) {
                            return value + '%'; // Agrega el símbolo "%" al valor
                        },
                    }
                },
            }
        }
    }
}
</script>
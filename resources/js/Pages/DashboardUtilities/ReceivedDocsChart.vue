<template>
    <div class=" w-full">
        <h2 class="text-base text-pink-500">All Logged Documents</h2>
        <apexchart
        width="100%"
        height="262px"
        type="bar"
        :options="bindChartData(ChartData, 1)"
        :series="bindChartData(ChartData, 2)"
        ></apexchart>
    </div>
    <pre>
        {{ chartOptions }}
    </pre>
</template>

<script>
    import VueApexCharts from "vue3-apexcharts";

    export default {
        props: {
            ChartData: Array,
        },
        components: {
            apexchart: VueApexCharts,
        },
        data(){
            return {
                showChart: 0,
            };
        },
        methods: {
            bindChartData(data, type){
                console.log("bindChartData");
                var series = [];
                var labels = []; 
                $.each(data, function(key, value) {
                    labels.push(key);
                    series.push(value.length);
                });
                if(type == 1){
                    var Options = {
                        chart: {
                            id: "vuechart-example",
                        },
                        xaxis: {
                            categories: labels,
                        },
                    }
                    return Options;
                }else{
                    var seriesArr = [
                        {
                            name: "Value",
                            data: series,
                        },
                    ]
                    return seriesArr;
                }
            },
        },
        created(){
            console.log("ReceivedDocsChart.vue");
        }
    };
</script>

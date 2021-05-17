<template>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-3 mx-auto flex flex-wrap">
            <div class="flex flex-wrap  lg:w-1/2 sm:w-2/3 content-start sm:pr-10">
                <div class="w-full sm:p-4 px-4 mb-6">
                    <h1 class="title-font font-medium text-base mb-2 text-gray-900">Most Received Documents</h1>
                    <div class="leading-relaxed">Documents Received from different offices and its APT's | <span class="text-green-500">Live</span> </div>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/3" v-for="(item, index) in ReceivedDocs" :key="index">
                    <h2 class="title-font font-medium text-3xl text-gray-900">{{ item.length }}</h2>
                    <p class="leading-relaxed text-xs">{{ getInitials(index) }}</p>
                    <p class="text-sm text-pink-500">{{ getAvgAPT(item) }}</p>
                </div>
            </div>
            <div class="lg:w-1/2 sm:w-1/3 w-full h-full rounded-lg mt-6 sm:mt-0">
                <received-docs-chart :ChartData="ReceivedDocs"></received-docs-chart>
            </div>
        </div>
    </section>

</template>

<script>
    import ReceivedDocsChart from './ReceivedDocsChart.vue';
	import Mylib from '@/CustomFunctions/Mylib.js';
    import moment from 'moment';

    export default {
        components: {
            ReceivedDocsChart,
        },
        data(){
            return {
                ReceivedDocs: null,
            }
        },
        methods: {
            getMostReceivedDocs(){
                axios.get('/getMostReceivedDocs',{
              }).then(function(response){
                    this.ReceivedDocs = response.data;
                }.bind(this));
            },
            getInitials(nameString){
                const fullName = nameString.split(' ');
                const initials = fullName.shift().charAt(0) + fullName.pop().charAt(0);
                return initials.toUpperCase();
            },
            getAvgAPT(item){
                console.log("getAvgAPT");
                var DateDiffArray = [];
                // Loop for Created and Updated Dates
                item.forEach(element => {
                // Get DateDiff via Moment
                    var duration = moment.duration(moment(element.updated_at).diff(moment(element.created_at)));
                    // hours = duration.asHours();
                    // Store to Array
                    DateDiffArray.push(duration);
                });
                // Sum all
                var sum = DateDiffArray.reduce(function(a, b){
                    return a + b;
                }, 0);

                // Get Avg
                console.log("DateDiffArray");
                console.log(DateDiffArray);
				return Mylib.dateAs(sum/DateDiffArray.length);
            }
        },
        created(){
            console.log("ReceivedDocs.vue");
            this.getMostReceivedDocs();
        }
    };
</script>

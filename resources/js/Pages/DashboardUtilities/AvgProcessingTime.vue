<template>
    <div class="container px-5 py-5 mx-auto flex flex-wrap">
        <h1 class="title-font font-medium text-xl mb-2 text-gray-900">Average Processing Time | All Documents</h1>
        <div class="block w-full">
            <h1 class="text-green-500 text-lg font-bold"> {{ this.AllReceivedDocs }} </h1>
        </div>
    </div>
</template>

<script>
    import AvgDocs from './AvgDocs.vue';
	import Mylib from '@/CustomFunctions/Mylib.js';
    import moment from 'moment';

    export default {
        components: { 
            AvgDocs 
        },
        data(){
            return {
                AllReceivedDocs: null,
            }
        },
        methods: {
            getAPTAllReceivedDocs(){
                axios.get('/getAPTAllReceivedDocs',{
              }).then(function(response){
                    console.log("this.getAvgAPT(response.data)");
                    this.AllReceivedDocs = this.getAvgAPT(response.data);
                }.bind(this));
            },
            getAvgAPT(item){
                console.log("getAvgAPT");
                var DateDiffArray = [];
                // Loop for Created and Updated Dates
                item.forEach(element => {
                // Get DateDiff via Moment
                    var duration = moment.duration(moment(element.updated_at).diff(moment(element.created_at)));
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
                console.log("sum");
                console.log(sum);
                console.log("sum/DateDiffArray.length");
                console.log(sum/DateDiffArray.length);
                console.log("DateDiffArray.length");
                console.log(DateDiffArray.length);

				return Mylib.dateAs(sum/DateDiffArray.length);
            }
        },
        created(){
            console.log("AvgProcessingTime.vue");
            this.getAPTAllReceivedDocs();
        }
    };
</script>

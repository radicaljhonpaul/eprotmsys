<template>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto flex flex-wrap">
            <div class="flex flex-wrap mt-auto mb-auto lg:w-1/2 sm:w-2/3 content-start sm:pr-10">
                <div class="w-full sm:p-4 px-4 mb-6">
                    <h1 class="title-font font-medium text-xl mb-2 text-gray-900">Most Received Documents</h1>
                    <div class="leading-relaxed">Documents Received from different offices | <span class="text-green-500">Live</span> </div>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/5">
                    <h2 class="title-font font-medium text-3xl text-gray-900">40</h2>
                    <p class="leading-relaxed">PR</p>
                    <p class="text-xs text-pink-500">2Hrs</p>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/5">
                    <h2 class="title-font font-medium text-3xl text-gray-900">58</h2>
                    <p class="leading-relaxed">Advisory</p>
                    <p class="text-xs text-pink-500">2Hrs</p>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/5">
                    <h2 class="title-font font-medium text-3xl text-gray-900">35</h2>
                    <p class="leading-relaxed">PO</p>
                    <p class="text-xs text-pink-500">2Hrs</p>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/5">
                    <h2 class="title-font font-medium text-3xl text-gray-900">4</h2>
                    <p class="leading-relaxed">Permit</p>
                    <p class="text-xs text-pink-500">2Hrs</p>
                </div>
                <div class="p-4 sm:w-1/2 lg:w-1/5">
                    <h2 class="title-font font-medium text-3xl text-gray-900">4</h2>
                    <p class="leading-relaxed">Certificates</p>
                    <p class="text-xs text-pink-500">2Hrs</p>
                </div>
            </div>
            <div class="lg:w-1/2 sm:w-1/3 w-full h-full rounded-lg mt-6 sm:mt-0">
                <received-docs-chart></received-docs-chart>
            </div>
        </div>
    </section>

</template>

<script>
    import ReceivedDocsChart from './ReceivedDocsChart.vue';

    export default {
        components: {
            ReceivedDocsChart,
        },
        data(){
            // return {
            //     IncomingModal: false,
            // }
        },
        created(){
            console.log("ReceivedDocs.vue");
        }
    };
</script>

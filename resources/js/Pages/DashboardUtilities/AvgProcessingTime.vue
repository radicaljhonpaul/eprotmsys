<template>
    <div class="container px-5 py-5 mx-auto flex flex-wrap">
        <h1 class="title-font font-medium text-xl mb-2 text-gray-900">Average Processing Time</h1>
        <div class="block w-full">
            <h1 class="text-green-500 text-lg font-bold">2 Hrs, 5 mins, 25 sec</h1>
        </div>
    </div>
</template>

<script>
    import AvgDocs from './AvgDocs.vue';

    export default {
        components: { 
            AvgDocs 
        },
        
    };
</script>

<template>
        <inertia-link v-if="current_page > 1" :href="prev_url" class="h-10 w-10 p-2 justify-center items-center flex rounded-full bg-blue-200 border-2 border-blue-500 cursor-pointer"> <i class="fas fa-chevron-left"></i> </inertia-link>
        <template v-for="link in total_page" :key="link">
            <inertia-link :href="path+'?page='+link" class="h-10 w-10 p-2 justify-center items-center flex rounded-full bg-blue-200 border-2 border-blue-500 cursor-pointer" :class="{ 'bg-blue-500': current_page ==  link }" > {{ link }} </inertia-link>
        </template>
        <inertia-link v-if="total_page != current_page" :href="next_url" class="h-10 w-10 p-2 justify-center items-center flex rounded-full bg-blue-200 border-2 border-blue-500 cursor-pointer"> <i class="fas fa-chevron-right"></i> </inertia-link>
</template>

<script>
    export default {
        props: {
            links: Array,
            current_page: Number,
            prev_url: "",
            next_url: "",
            total_page: Number,
            path: "",
        },
        created(){
            console.log(this.links);
        },
        methods:{
            char(){
                console.log("LINKS");
                console.log(this.links);
            }
        }
    }
</script>
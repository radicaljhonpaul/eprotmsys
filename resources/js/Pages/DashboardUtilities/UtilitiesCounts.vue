<template>
    <section class="text-gray-600 body-font">
        <div class="container px-5 mx-auto">
            <h1 class="title-font font-medium text-xl mb-2 text-gray-900">Purchase Request - Purchase Order</h1>
            <div class="flex flex-wrap text-left">
                <div class="md:w-1/4 w-full px-2">
                    <div class="border-b-2 border-gray-200 px-4 py-2 flex flex-wrap gap-3">
                        <img style="width:50px;height:50px;object-fit:contain;" src="/images/dashboard/pr_rec.gif" alt="">
                        <div>
                            <h2 class="title-font font-medium text-3xl text-gray-900">{{ this.PR_Received }}</h2>
                            <p class="leading-relaxed">PR | <span class="text-green-500"> Received </span> </p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/4 w-full px-2">
                    <div class="border-b-2 border-gray-200 px-4 py-2 flex flex-wrap gap-3">
                        <img style="height:50px;object-fit:contain;" src="/images/dashboard/pr_app.gif"/>
                        <div>
                            <h2 class="title-font font-medium text-3xl text-gray-900">{{ this.PR_Approved }}</h2>
                            <p class="leading-relaxed">PR | <span class="text-yellow-500"> Approved </span> </p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/4 w-full px-2">
                    <div class="border-b-2 border-gray-200 px-4 py-2 flex flex-wrap gap-3">
                        <img style="height:50px;object-fit:contain;" src="/images/dashboard/po_rec.gif"/>
                        <div>
                            <h2 class="title-font font-medium text-3xl text-gray-900">{{ this.PO_Received }}</h2>
                            <p class="leading-relaxed">PO | <span class="text-yellow-500"> Received </span> </p>
                        </div>
                    </div>  
                </div>
                <div class="md:w-1/4 w-full px-2">
                    <div class="border-b-2 border-gray-200 px-4 py-2 flex flex-wrap gap-3">
                        <img style="height:50px;object-fit:contain;" src="/images/dashboard/po_app.gif"/>
                        <div>
                            <h2 class="title-font font-medium text-3xl text-gray-900">{{ this.PO_Approved }}</h2>
                            <p class="leading-relaxed">PO | <span class="text-green-500"> Approved </span> </p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        components: { 
        },
        data(){
            return {
                PR_Data: null,
                PR_Approved: null,
                PR_Received: null,
                PO_Data: null,
                PO_Received: null,
                PO_Approved: null,
            }
        },
        methods: {
            getUtilitiesCounts(){
                axios.get('/getUtilitiesCounts',{
              }).then(function(response){
                    this.PR_Received = response.data[0];
                    this.PR_Approved = response.data[1];
                    this.PO_Received = response.data[2];
                    this.PO_Approved = response.data[3];
                }.bind(this));
            }
        },
        created(){
            console.log("UtilitiesCounts.vue");
            this.getUtilitiesCounts();
        }
    };
</script>

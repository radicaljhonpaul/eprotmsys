<template>
    <office-layout>
        <received-docs></received-docs>
        <utilities-counts></utilities-counts>
        <avg-processing-time></avg-processing-time>
    </office-layout>
</template>

<script>
    import OfficeLayout from '@/Layouts/OfficeLayout'
    import ReceivedDocs from '../DashboardUtilities/ReceivedDocs.vue';
    import UtilitiesCounts from '../DashboardUtilities/UtilitiesCounts.vue';
    import AvgProcessingTime from '../DashboardUtilities/AvgProcessingTime.vue';

    export default {
        components: {
            OfficeLayout,
            ReceivedDocs,
            UtilitiesCounts,
            AvgProcessingTime,
        },
        data(){
            return {
                IncomingModal: false,
                currentChannel: null,
            }
        },
        created(){
            // console.log(this.$attrs.UsersDetails[0].id);
            // window.Echo.private('UsersArray_'+this.$attrs.UsersDetails[0].id)
            // .listen('UsersEvents', (e) => {
            //     console.log(e.data.message +' From: '+ e.data.id);
            // });
        }
    };
</script>

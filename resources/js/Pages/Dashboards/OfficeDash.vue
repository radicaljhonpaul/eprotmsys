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

            // Echo.channel('progressBar')
            // .listen('UpdateProgressData', e => {
            //     console.log('UpdateProgressData has been updated!');
            //     console.log(e);
            // });
            window.Echo.channel('UsersArray')
            .listen('UsersEvents', (e) => {
                console.log("Sdsds");
            });
        }
    };
</script>

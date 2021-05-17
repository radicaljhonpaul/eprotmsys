<template>
    <jet-dropdown align="right" width="80">
        <template #trigger>
            <button class="flex px-2 border-transparent text-gray-500 rounded-full focus:outline-none focus:border-gray-200 transition duration-150 ease-in-out">
                <i class="fas fa-bell" style="font-size:1.2rem;"></i> <div style="padding-top: 0.2em; padding-bottom: 0.1em; font-size:0.7em;" class="px-1 bg-red-500 -ml-2 text-white rounded-full">{{ this.NotificationList.length }}</div>
            </button>
        </template>

        <template #content>
            <!-- Notifications -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                Notifications
            </div>
            <div class="h-56 overflow-y-auto">
                <div v-for="notif in this.NotificationList" :key="notif">
                    <span @click="readNotifications(notif.id,notif.notification_events_tbl.event_type)" class="flex items-center px-4 py-3 border-b cursor-pointer bg-white hover:bg-gray-100 disabled:bg-gray-300" :disabled="notif.is_open == 0">
                        <i class="fas fa-file-alt text-blue-500 mx-2"></i>
                        <p class="text-gray-600 mx-2 text-xs">
                            <!-- If !null ang from -->
                            <span v-if="notif.users_details != null" class="font-normal">
                                {{ notif.notification_events_tbl.event_type +'with DTRAK No: '+ notif.dtrack_id_fk }}
                            </span>
                            <!-- If !null ang to -->
                            <span v-if="notif.users_details == null" class="font-normal">
                                {{ notif.notification_events_tbl.event_text }}
                            </span>
                            <br/>
                            <span class="font-bold text-blue-500" style=".2em">{{ dateDifference(notif.created_at,this.DateNow) }}</span>
                        </p>
                    </span>
                </div>
            </div>
            <a href="#" class="block bg-gray-800 text-sm text-white text-center font-bold py-1 hover:bg-white hover:text-gray-800">See all notifications</a>
        </template>
    </jet-dropdown>
</template>

<script>
    import JetDropdown from '@/Jetstream/Dropdown'
	import moment from 'moment'
	import Mylib from '@/CustomFunctions/Mylib.js';


    export default {
        components: {
            JetDropdown
        },
        data() {
            return {
                NotificationList: [],
                DateNow: moment(),
                readNotif: false,
            }
        },
        created(){
            console.log("NotificationList.vue Created");
            this.getUserNotifications();
        },
        methods: {
            getUserNotifications(){
                axios.get('/getUserNotifications')
                .then(function (response) {
                    this.NotificationList = response.data;
                    console.log(this.NotificationList);
                }.bind(this));
            },
			dateDifference: function(startDate,endDate) {
				return Mylib.dateDifference(startDate,endDate);
        	},
            readNotifications(notif_id,event_type){
                console.log(notif_id);
                axios.get('/readNotifications',{
                    params: {
                        notif_id: notif_id,
                        event_type: event_type
                    }
                }).then(function(response){
                    console.log(response.data);
                    if(response.data == 1 && event_type == 'Created a Document'){
                        window.location.href="/office/mydocs";
                    }else;

                    if(response.data == 1 && event_type == 'Logged a Document'){
                        window.location.href="/office/logged";
                    }else;

                    if(response.data == 1 && event_type == 'Received and Route a Document'){
                        window.location.href="/office/outgoing";
                    }else;  
                }.bind(this));
            },
        },
    };
</script>

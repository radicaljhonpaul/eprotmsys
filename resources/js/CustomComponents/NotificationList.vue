<template>
    <jet-dropdown align="right" width="80">
        <template #trigger>
            <button class="flex text-sm px-2 border-transparent text-gray-500 rounded-full focus:outline-none focus:border-gray-200 transition duration-150 ease-in-out">
                <i class="fas fa-bell" style="font-size:1.2rem;"></i>
            </button>
        </template>

        <template #content>
            <!-- Notifications -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                Notifcations
            </div>

            <div v-for="notif in this.NotificationList" :key="notif" @click="readNotif(notif.id)">
                <a href="#" class="flex items-center px-4 py-3 border-b bg-white hover:bg-gray-100 disabled:bg-gray-300" :disabled="notif.is_open == 0">
                    <i class="fas fa-file-alt text-blue-500 mx-2"></i>
                    <p class="text-gray-600 mx-2 text-xs">
                        <!-- If !null ang from -->
                        <span v-if="notif.users_details != null" class="font-normal" href="#">
                             {{ notif.notification_events_tbl.event_type +'with DTRAK No: '+ notif.dtrack_id_fk }}
                        </span>
                        <!-- If !null ang to -->
                        <span v-if="notif.users_details == null" class="font-normal" href="#">
                             {{ notif.notification_events_tbl.event_text }}
                        </span>
                        <br/>
                        <span class="font-bold text-blue-500" style=".2em">{{ dateDifference(notif.created_at,this.DateNow) }}</span>
                    </p>
                </a>
            </div>
            <a href="#" class="block bg-gray-800 text-white text-center font-bold py-2 hover:bg-white hover:text-gray-800">See all notifications</a>
        </template>
    </jet-dropdown>
</template>

<script>
    import JetDropdown from '@/Jetstream/Dropdown'
	import moment from 'moment'

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
                var b = moment(startDate),
                    a = moment(endDate),
                    intervals = ['hours','minutes'],
                    out = [];

                for(var i=0; i<intervals.length; i++){
                    var diff = a.diff(b, intervals[i]);
                    b.add(diff, intervals[i]);
                    out.push(diff + ' ' + intervals[i]);
                }
                return out.join(', ');                                                      
        	},
            readNotifications(notif_id){
                axios.get('/readNotifications',{
                    params: {
                        notif_id: notif_id
                    }
                }).then(function(response){
                    console.log(response.data);
                }.bind(this));
            },
        },
    };
</script>

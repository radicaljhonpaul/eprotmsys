<template>
    <div>
        <jet-banner />
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('office.dashboard.index')">
                                    <jet-application-mark class="block h-9 w-auto" />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('office.dashboard.index')" :active="route().current('office.dashboard.index')">
                                    Dashboard &nbsp; <i class="fas fa-satellite-dish text-gray-800"></i>
                                </jet-nav-link>

                                <jet-nav-link :href="route('office.mydocs')" :active="route().current('office.mydocs')">
                                    My Documents &nbsp; <i class="fas fa-file-alt text-gray-800"></i>
                                </jet-nav-link>

                                <jet-nav-link :href="route('office.incoming')" :active="route().current('office.incoming')">
                                    Incoming Documents &nbsp; <i class="fas fa-file-import text-gray-800"></i>
                                </jet-nav-link>

                                <jet-nav-link :href="route('office.outgoing')" :active="route().current('office.outgoing')"> 
                                    Forwarded Documents &nbsp; <i class="fas fa-file-export text-gray-800"></i>
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="relative">
                                <!-- Teams Dropdown -->
                                <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!-- Notif Dropdown -->
                            <div class="relative">
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

                                        <div class="py-2">
                                            <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100">
                                                <img class="h-8 w-8 rounded-full object-cover mx-1" src="/images/track.png" alt="avatar">
                                                <p class="text-gray-600 text-sm mx-2">
                                                    <span class="font-bold" href="#">Sara Salah</span> replied on the <span class="font-bold text-blue-500" href="#">Upload Image</span> artical . 2m
                                                </p>
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100">
                                                <img class="h-8 w-8 rounded-full object-cover mx-1" src="/images/track.png" alt="avatar">
                                                <p class="text-gray-600 text-sm mx-2">
                                                    <span class="font-bold" href="#">Slick Net</span> start following you . 45m
                                                </p>
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100">
                                                <img class="h-8 w-8 rounded-full object-cover mx-1" src="/images/track.png" alt="avatar">
                                                <p class="text-gray-600 text-sm mx-2">
                                                    <span class="font-bold" href="#">Jane Doe</span> Like Your reply on <span class="font-bold text-blue-500" href="#">Test with TDD</span> artical . 1h
                                                </p>
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-100">
                                                <img class="h-8 w-8 rounded-full object-cover mx-1" src="/images/track.png" alt="avatar">
                                                <p class="text-gray-600 text-sm mx-2">
                                                    <span class="font-bold" href="#">Abigail Bennett</span> start following you . 3h
                                                </p>
                                            </a>
                                        </div>
                                        <a href="#" class="block bg-gray-800 text-white text-center font-bold py-2 hover:bg-white hover:text-gray-800">See all notifications</a>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="80">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-200 transition duration-150 ease-in-out">
                                            <img v-if="$page.props.user.profile_photo_path" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" :src="'/storage/'+$page.props.user.profile_photo_path" :alt="$page.props.user.email" />
                                            <img v-if="$page.props.user.profile_photo_path == null && $page.props.UsersDetails[0].gender == 'Male'" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" src="/images/no_profile_pic/male.gif">
                                            <img v-if="$page.props.user.profile_photo_path == null && $page.props.UsersDetails[0].gender == 'Female'" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" src="/images/no_profile_pic/female.gif">
                                        </button>

                                        <span v-if="!$page.props.jetstream.managesProfilePhotos" class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <span class="text-pink-500 text-xs">
                                                    {{ $page.props.user.email }}
                                                </span>

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-gray-400">
                                            <p class="text-base">
                                                {{ $page.props.UsersDetails[0].fname +' '+ $page.props.UsersDetails[0].lname}}
                                            </p>
                                            <span class="text-pink-500 text-xs"> {{ $page.props.UsersDetails[0].position }} </span>
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            Profile
                                        </jet-dropdown-link>

                                        <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                            API Tokens
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Log Out
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>

                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link :href="route('office.dashboard.index')" :active="route().current('office.dashboard.index')">
                            Dashboard
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('office.mydocs')" :active="route().current('office.mydocs')">
                            My Documents &nbsp; <i class="fas fa-file-alt text-gray-800"></i>
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('office.incoming')" :active="route().current('office.incoming')">
                            Incoming Documents &nbsp; <i class="fas fa-file-import text-gray-800"></i>
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('office.outgoing')" :active="route().current('office.outgoing')"> 
                            Forwarded Documents &nbsp; <i class="fas fa-file-export text-gray-800"></i>
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                <img v-if="$page.props.user.profile_photo_path" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" :src="'/storage/'+$page.props.user.profile_photo_path" :alt="$page.props.user.email" />
                                <img v-if="$page.props.user.profile_photo_path == null && $page.props.UsersDetails[0].gender == 'Male'" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" src="/images/no_profile_pic/male.gif">
                                <img v-if="$page.props.user.profile_photo_path == null && $page.props.UsersDetails[0].gender == 'Female'" class="h-8 w-8 border-2 border-gray-200 rounded-full object-cover" src="/images/no_profile_pic/female.gif">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.UsersDetails[0].fname +' '+ $page.props.UsersDetails[0].lname}}
                                </div>
                                <div class="font-medium text-xs text-gray-500">{{ $page.props.UsersDetails[0].position }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"></div>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </jet-responsive-nav-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <jet-responsive-nav-link as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </jet-responsive-nav-link>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>

        <!--Notifications -->
        <notificationGroup group="Notifications_Btm" position="bottom">
            <div class="fixed inset-0 flex px-4 py-6 pointer-events-none p-6 items-start justify-end">
                <div class="max-w-sm w-full">
                <notification v-slot="{notifications}">
                    <div v-for="notification in notifications" :key="notification.id">
                        <div v-if="notification.type==='info'" class="flex max-w-sm w-full mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-4">
                            <div class="flex justify-center items-center w-12 bg-blue-500">
                            <svg
                                class="h-6 w-6 fill-current text-white"
                                viewBox="0 0 40 40"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"
                                />
                            </svg>
                            </div>

                            <div class="-mx-3 py-2 px-4">
                            <div class="mx-3">
                                <span class="text-blue-500 font-semibold">{{notification.title}}</span>
                                <p class="text-gray-600 text-sm">T{{notification.text}}</p>
                            </div>
                            </div>
                        </div>
                        <div v-if="notification.type==='warning'" class="flex max-w-sm w-full mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-4">
                            <div class="flex justify-center items-center w-12 bg-yellow-500">
                            <svg
                                class="h-6 w-6 fill-current text-white"
                                viewBox="0 0 40 40"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"
                                />
                            </svg>
                            </div>

                            <div class="-mx-3 py-2 px-4">
                            <div class="mx-3">
                                <span class="text-yellow-500 font-semibold">{{notification.title}}</span>
                                <p class="text-gray-600 text-sm">{{notification.text}}</p>
                            </div>
                            </div>
                        </div>
                        <div v-if="notification.type==='error'" class="flex max-w-sm w-full mx-auto bg-white shadow-md rounded-lg overflow-hidden mt-4">
                            <div class="flex justify-center items-center w-12 bg-red-500">
                            <svg
                                class="h-6 w-6 fill-current text-white"
                                viewBox="0 0 40 40"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"
                                />
                            </svg>
                            </div>

                            <div class="-mx-3 py-2 px-4">
                            <div class="mx-3">
                                <span class="text-red-500 font-semibold">{{notification.title}}</span>
                                <p class="text-gray-600 text-sm">{{notification.text}}</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </notification>
                </div>
            </div>
        </notificationGroup>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
        created(){
            console.log("user_ID");
            console.log(this.$page.props.user.id);

            Echo.private('CreateDocument_'+this.$page.props.user.id)
            .listen('CreateDocument', (e) => {
                console.log(e.data.message +' From: '+ e.data.id);
                this.$notify(
                    {
                        group: "Notifications_Btm",
                        title: "Info",
                        text: e.data.message,
                        type: "warning",
                    },
                    5000
                );
            });
        },
        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
			retDiv(div){
				// var type2 = [];
				var divs = [
					"",
					"RD's OFFICE",
					"ARD's OFFICE",
					"LHSD",
					"MSD",
					"RLED",
				]
                
                if(div != 0){
                    return divs[div];
                }else{
                    return divs[0]
                }
			},
            retSec(sec){
                var secs = [
					"",
					"NNC",
					"PHILHEALTH INSURANCE CORP.",
					"ADELA SIERRA TY MEMORIAL MEDICAL CENTER",
					"CARAGA REGIONAL HOSPITAL",
					"DRUG TREATMENT AND REHAB.",
					"OFFICE OF STRATEGIC MANAGEMENT",
					"PDO ADS",
					"PDO ADN",
					"PDO SDN",
					"PDO SDS",
					"PDO PDI",
					"RESSU/HEMS",
					"PLANNING SECTION",
					"RESEARCH SECTION",
					"LEGAL SECTION",
					"FINANCE SECTION",
					"HR MNGT. & DEV. SECTION",
					"HEALTH FACILITY SECTION",
					"HEALTH PROGRAM SECTION",
					"PROCUREMENT SECTION",
					"MATERIAL MNGT. SECTION",
					"GOVERNANCE SECTION",
					"FAMILY HEALTH SECTION",
					"INFECTIOUS SECTION",
					"NON-COMMUNICABLE DISEASES SECTION",
				]

                if(sec != 0){
                    return secs[sec];
                }else{
                    return secs[0]
                }
            },
            retClus(clus){
				var cluster = [
					"",
					"PERSONNEL",
					"TRAINING",
					"HEALTH PROMOTION",
					"KNOWLEDGE MANAGEMENT CLUSTER",
					"DEPLOYMENT PROGRAM CLUSTER",
					"BUDGET",
					"ACCOUNTING",
					"CASHIER",
				]

                if(clus != 0){
                    return cluster[clus];
                }else{
                    return cluster[0]
                }
            },
        }
    };
</script>

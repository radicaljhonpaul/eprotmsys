<template>
    <div>
        <div class="flex w-screen h-screen text-gray-700">
            <!-- Component Start -->
            <div class="flex flex-col items-center w-16 pb-4 overflow-auto border-r border-gray-300">
                <a class="flex items-center justify-center flex-shrink-0 w-full h-16" href="#">
                    <img class="h-8 w-8 border-2 border-gray-700 rounded-full object-cover" src="/images/no_profile_pic/male.gif">
                </a>

                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.index')">
                    <i class="fas fa-home"></i>
                </jet-admin-responsive-nav-link>
                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.documents')">
                    <i class="fas fa-clipboard-list"></i>
                </jet-admin-responsive-nav-link>
                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.users')">
                    <i class="fas fa-users"></i>
                </jet-admin-responsive-nav-link>
                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.reports')">
                    <i class="fas fa-bullhorn"></i>
                </jet-admin-responsive-nav-link>
                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.feedback')">
                    <i class="fas fa-comment-dots"></i>
                </jet-admin-responsive-nav-link>
                <jet-admin-responsive-nav-link :href="route('admin.dashboard.index')" :active="route().current('admin.dashboard.settings')">
                    <i class="fas fa-cogs"></i>
                </jet-admin-responsive-nav-link>

                <form method="POST" @submit.prevent="logout">
                    <jet-responsive-nav-link as="button">
                        Log Out
                    </jet-responsive-nav-link>
                </form>

            </div>

            <div class="flex flex-col flex-grow">
                <!-- Nav -->
                <div class="flex items-center flex-shrink-0 h-16 p-6 border-b border-gray-300">
                    <h1 class="text-lg font-medium">Page Title</h1>
                </div>

                <!-- Dash Body -->
                <div class="flex-grow p-6 overflow-auto bg-gray-200">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-3 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-3 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-1 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-2 bg-white border border-gray-300"></div>
                        <div class="h-24 col-span-3 bg-white border border-gray-300"></div>
                    </div>
                </div>
            </div>
            <!-- Component End  -->
        </div>
    </div>
</template>

<script>
    import JetAdminResponsiveNavLink from '@/Jetstream/AdminResponsiveNavLink'
    import NotificationList from '../CustomComponents/NotificationList.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetAdminResponsiveNavLink,
            NotificationList,
            JetResponsiveNavLink,
        },
        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
        created(){
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },

        }
    };
</script>

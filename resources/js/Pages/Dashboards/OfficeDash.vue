<template>
    <office-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <i class="fas fa-inbox 3x text-gray-800"></i>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                    <a href="https://laravel.com/docs">Received Purchase Request</a>
                                </div>
                            </div>

                            <div class="ml-12">
                                <small class="text-green-500">as of March 02, 2021 (Today)</small>
                                <div class="mt-2 text-6xl text-gray-500">
                                    52
                                </div>

                                <button class="bg-white text-green-500 hover:bg-green-500 hover:text-white border border-green-500 px-3 py-1 mx-0 outline-none rounded-2xl focus:shadow-outline" type="button" @click="IncomingModal = true">Receive a document</button>

                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <i class="fas fa-inbox 3x text-gray-800"></i>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laracasts.com">Received Purchase Order</a></div>
                            </div>

                            <div class="ml-12">
                                <small class="text-green-500">as of March 02, 2021 (Today)</small>
                                <div class="mt-2 text-6xl text-gray-500">
                                    28
                                </div>

                                <a href="https://laravel.com/docs">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                        <div>Receving a Purchase Order? &nbsp; <i class="fas fa-folder-open "></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200">
                            <div class="flex items-center">
                                <i class="fas fa-stopwatch-20 3x text-gray-800"></i>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://tailwindcss.com/">Average Processing Time PR</a></div>
                            </div>

                            <div class="ml-12">
                                <small class="text-green-500">as of March 02, 2021 (Today)</small>
                                <div class="mt-2 text-5xl text-gray-500">
                                    2 Hr/s 10 Min
                                </div>

                                <a href="https://laravel.com/docs">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-yellow-500">
                                            <div>View APT per office? &nbsp; <i class="fas fa-info-circle"></i>
                                            </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <i class="fas fa-stopwatch-20 3x text-gray-800"></i>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Average Processing Time PO</div>
                            </div>

                            <div class="ml-12">
                                <small class="text-green-500">as of March 02, 2021 (Today)</small>
                                <div class="mt-2 text-5xl text-gray-500">
                                    20 Hr/s 11 Min
                                </div>

                                <a href="https://laravel.com/docs">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-yellow-500">
                                            <div>View APT per office? &nbsp; <i class="fas fa-info-circle"></i>
                                            </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <modal :show="IncomingModal">
            <h1>dsdsdsdsds</h1>
        </modal>

    </office-layout>
</template>

<script>
    import OfficeLayout from '@/Layouts/OfficeLayout'
    import Modal from '@/Jetstream/Modal'

    export default {
        components: {
            OfficeLayout,
            Modal,
        },
        data(){
            return {
                IncomingModal: false,
            }
        }
    };
</script>

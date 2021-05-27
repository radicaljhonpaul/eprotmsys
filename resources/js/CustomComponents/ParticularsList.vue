<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="py-2 align-middle inline-block min-w-full">
        <section class="border-b text-gray-500 flex justify-between items-center">
            <span class="text-1xl font-semibold">Particulars</span><br>
        </section>
        <div class="overflow-hidden border border-gray-200 ">
            <table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg border-2 border-gray-600 lg:border-0">
                <thead class="flex-1 sm:flex-none text-xs bg-gray-600 text-white divide-y divide-gray-800">
                    <tr v-for="(item, index) in Particulars" :key="index" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
                        <th scope="col" class="h-8 px-3 py-2 text-left lg:h-full uppercase">
                            No
                        </th>
                        <th scope="col" class="h-12 px-3 py-2 text-left lg:h-full uppercase">
                            Item
                        </th>
                        <th scope="col" class="h-8 px-3 py-2 text-left lg:h-full uppercase">
                            Qty
                        </th>
                        <th scope="col" class="h-8 px-3 py-2 text-left lg:h-full uppercase">
                            Unit
                        </th>
                        <th scope="col" class="h-16 px-3 py-2 text-left lg:h-full uppercase">
                            Amount
                        </th>
                        <th scope="col" class="h-16 px-3 py-2 text-left lg:h-full uppercase">
                            Purpose
                        </th>
                    </tr>
                </thead>
                <tbody class="flex-1 sm:flex-none bg-white divide-y divide-gray-800 lg:divide-y lg:divide-gray-200 text-purple-500 text-xs">
                    <tr v-for="(item, index) in Particulars" :key="item.created_at" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
                        <td class="h-8 px-3 py-2 text-left lg:h-full ">{{ forIndex(index) }}</td>
                        <td class="h-12 px-3 py-2 text-left lg:h-full ">{{ item.Item }}</td>
                        <td class="h-8 px-3 py-2 text-left lg:h-full ">{{ item.item_qty }}</td>
                        <td class="h-8 px-3 py-2 text-left lg:h-full ">{{ item.item_unit }}</td>
                        <td class="h-16 px-3 py-2 text-left lg:h-full ">₱ {{ formatAmount(item.item_amount) }}</td>
                        <td class="h-16 px-3 py-2 text-left lg:h-full ">{{ item.purpose }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
	import moment from 'moment'
	import Mylib from '@/CustomFunctions/Mylib.js';


    export default {
        props: {
            Particulars: null,
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
        },
        methods: {
            forIndex(index) {
				return index+1
			},
			formatAmount(value) {
				return Mylib.formatAmount(value);
			},
        },
    };
</script>

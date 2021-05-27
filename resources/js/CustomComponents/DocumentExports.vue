<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <table id="datatable" class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg my-5 border-2 border-pink-600 lg:border-0">
        <thead class="flex-1 sm:flex-none text-xs bg-pink-600 text-white divide-y divide-pink-800">
            <tr class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
                <th class="px-3 py-2 text-left lg:h-full">DTRAK No.</th>
                <th class="px-3 py-2 text-left lg:h-full">Created/Received</th>
                <th class="px-3 py-2 text-left lg:h-full">Origin</th>
                <th class="px-3 py-2 text-left lg:h-full">Document</th>
                <th class="px-3 py-2 text-left lg:h-full">Particulars</th>
                <th class="px-3 py-2 text-left lg:h-full">Forwarded</th>
                <th class="px-3 py-2 text-left lg:h-full">Assessment</th>
            </tr>
        </thead>
        <tbody class="flex-1 sm:flex-none bg-white divide-y divide-pink-800 lg:divide-y lg:divide-gray-200">
            <tr v-for="docs in Documents.data" :key="docs" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
                <td class="px-3 py-2 lg:h-full">
                    <div class="text-xs font-medium text-gray-900">
                        {{ docs.documents_tbl.dtrack_no }}
                    </div>
                </td>
                <td class="px-3 py-2 lg:h-full">
                    <div class="text-xs font-medium text-gray-900">
                        {{ frontEndDateFormat(docs.created_at) }}
                    </div>
                </td>
                <td class="px-3 py-2 lg:h-full">
                    <div class="text-xs font-medium text-gray-900">
                        <span v-if="docs.documents_tbl.users_details.gender == 'Male'">
                            Mr.
                        </span>	
                        <span v-else>
                            Ms.
                        </span>	
                        {{ docs.documents_tbl.users_details.lname }}
                    </div>
                </td>
                <td class="px-3 py-2 lg:h-full">
                    <div class="text-xs text-gray-900">{{ docs.documents_tbl.doc_type }} </div>
                </td>
                <td class="px-3 py-2 lg:h-full">
                    <div class="text-xs text-gray-500">{{ docs.documents_tbl.documents_particulars_tbl.length }} Particulars</div>
                </td>
                <!-- Details on Receiving Date etc -->
                <td class="px-3 py-2 text-gray-900 lg:h-full">
                    <doc-destination style="font-size:.55rem;line-height:1rem;" :Destination="docs.forwarded_to"></doc-destination>	
                    <p class="text-xs">{{ frontEndDateFormat(docs.updated_at) }}</p>
                </td>
                
                <td class="px-3 py-2 lg:h-full text-gray-900">
                    <p class="text-xs text-gray-900">{{ dateDifference(docs.created_at,docs.updated_at) }} </p>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
	import moment from 'moment'
	import Mylib from '@/CustomFunctions/Mylib.js';
	import DocDestination from '@/CustomComponents/DocDestination.vue'

    export default {
        components: {
			DocDestination,
        },
        props: {
            Documents: null,
        },
        data() {
            return {
            }
        },
        created(){
            console.log("DocumentExports.vue Created");
        },
        methods: {
            forIndex(index) {
				return index+1
			},
			frontEndDateFormat: function(date_data) {
				return Mylib.frontEndDateFormat(date_data);
        	},
			dateDifference: function(startDate,endDate) {
				return Mylib.dateDifference(startDate,endDate);
        	},
        },
    };
</script>

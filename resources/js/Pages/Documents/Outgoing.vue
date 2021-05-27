<template>
	<office-layout>
		<div class="py-6">
			<div class="w-full px-2 mx-auto sm:px-6 lg:px-8">
				<span class="text-lg font-bold text-gray-900">
					Forwarded Documents
				</span>
				<div class="lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<div class="flex-1 min-w-0">
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
							<div class="border overflow-hidden flex ">
								<input type="text" class="py-2 bg-white border-b-2 border-green-600 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-base text-green-600 focus:outline-none focus:ring-0" v-model="SearchDoc" placeholder="Search Docs here...">
								<button v-if="this.SearchDoc != ''"  @click="searchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-green-600 hover:bg-green-600 hover:text-white focus:outline-none border-green-600">
									<i class="fas fa-search"></i>
								</button>
								<button @click="resetSearchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-green-600 hover:bg-green-600 hover:text-white focus:outline-none border-green-600">
									<i class="fas fa-window-restore"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="mt-5 flex lg:mt-0 lg:ml-4">
					</div>
				</div>

                <!-- Table -->
				<div class="w-full lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg my-5 border-2 border-green-600 lg:border-0">
						<thead class="flex-1 sm:flex-none text-xs bg-green-600 text-white divide-y divide-green-800">
							<tr v-show="Documents.data.length > 0" v-for="docs in Documents.data" :key="docs" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-16 px-3 py-2 text-left lg:h-full">End-User</th>
								<th class="h-36 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-24 px-3 py-2 text-left lg:h-full">Forwarded</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Assessment</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
							<tr v-if="Documents.data.length == 0" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-16 px-3 py-2 text-left lg:h-full">End-User</th>
								<th class="h-36 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-24 px-3 py-2 text-left lg:h-full">Forwarded</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Assessment</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
						</thead>
						<tbody class="flex-1 sm:flex-none bg-white divide-y divide-green-800 lg:divide-y lg:divide-gray-200">
							<tr v-if="!Documents.data.length">
								<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
									No Data Available
								</td>
							</tr>
							<tr v-show="Documents.data.length > 0" v-for="docs in Documents.data" :key="docs" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<td class="h-16 px-3 py-2 lg:h-full">
									<div class="flex items-center">
										<div class="flex-shrink-0 h-10 w-10">

											<img class="h-10 w-10 rounded-full object-cover" :src="'/storage/'+docs.documents_tbl.users_details.user.profile_photo_path" alt="">
										</div>
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
												<span v-if="docs.documents_tbl.users_details.gender == 'Male'">
													Mr.
												</span>	
												<span v-else>
													Ms.
												</span>	
												{{ docs.documents_tbl.users_details.lname }}
											</div>
										</div>
									</div>
								</td>
								<td class="h-36 px-3 py-2 lg:h-full">
									<div class="text-xs text-gray-900">{{ docs.documents_tbl.doc_type }} </div>
									<div class="text-xs text-gray-500">{{ docs.documents_tbl.documents_particulars_tbl.length }} Particulars</div>
									<div class="text-xs text-green-600">DTRAK No. {{ docs.documents_tbl.dtrack_no }}</div>
									<p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.created_at) }} </p>	
								</td>
								<!-- Details on Receiving Date etc -->
								<td class="h-24 px-3 py-2 text-gray-900 lg:h-full">
									<doc-destination style="font-size:.55rem;line-height:1rem;" :Destination="docs.forwarded_to"></doc-destination>	
									<p class="text-xs">{{ frontEndDateFormat(docs.updated_at) }}</p>
								</td>
								<td class="h-16 px-3 py-2 lg:h-full text-gray-900">
									<p class="text-xs text-gray-900">{{ dateDifference(docs.created_at,docs.updated_at) }} </p>
								</td>
								<td class="h-12 text-left px-3 py-2 lg:h-full text-sm font-medium">
									<a @click="ViewingModal = true, viewParticulars(docs.documents_tbl), toggleParticularsDocHistory()" class="text-green-500 hover:text-green-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="flex gap-2 pt-2 w-full overflow-x-auto">
					<pagination :links="Documents.links" :current_page="Documents.current_page" :prev_url="Documents.prev_page_url" :next_url="Documents.next_page_url" :total_page="Documents.last_page" :path="Documents.path"></pagination>
				</div>
			</div>
		</div>

		<!-- Modal for Viewing Document -->
		<modal :show="ViewingModal" >
			<div class="py-2">
				<form>
					<section class="flex flex-wrap border-b border-gray-300 px-5 items-center">
						<div class="w-full lg:w-3/4 text-gray-500">
							<p class="lg:text-2xl font-semibold">{{ SpecificDocData.doc_type }} </p>
							<p class="text-xs font-light mt-0" >Origin: {{ this.OriginFname }}  {{ this.OriginLname }} </p>
						</div>
						<div class="w-full lg:w-1/4 ">
							<div class="text-xs text-gray-500">Dtrack No. <span class="text-green-500">{{ SpecificDocData.dtrack_no }}</span> </div>
							<div class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Request'">PR No.
								<span class="text-green-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_from }}</span>
							</div>
							<div class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Order'">PO No.
								<span class="text-green-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_to }}</span>
							</div>
							<div class="text-xs text-gray-500 font-light ml-auto">Created On: {{ frontEndDateFormat(SpecificDocData.created_at) }}</div>	
						</div>
					</section>

					<!-- Particulars -->
					<section class="flex gap-x-4 px-5 mt-2 overflow-x-auto" v-if="!ToggleDocsHistory_Particulars">
						<particulars-list :Particulars="SpecificDocData.documents_particulars_tbl"></particulars-list>
					</section>

					<section class="px-5 mt-2  overflow-x-auto" v-if="ToggleDocsHistory_Particulars">
						<table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden my-5 border-2 border-gray-600">
							<thead class="flex-1 sm:flex-none text-xs bg-gray-600 text-white divide-y divide-gray-800">
								<tr v-for="history in SpecificDocData.documents_status_log_tbl" :key="history" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
									<th class="h-12 px-3 py-2 text-left lg:h-full">
										Date
									</th>
									<th class="h-16 px-3 py-2 text-left lg:h-full">
										Location
									</th>
									<th class="h-24 px-3 py-2 text-left lg:h-full">
										Remarks/Notes & Action
									</th>
									<th class="h-16 px-3 py-2 text-left lg:h-full">
										Destination
									</th>
									<th class="h-16 px-3 py-2 text-left lg:h-full">
										Attachments
									</th>
								</tr>
							</thead>
							<tbody class="flex-1 sm:flex-none bg-white divide-y divide-gray-800 lg:divide-y lg:divide-gray-200">
								<tr v-for="history in SpecificDocData.documents_status_log_tbl" :key="history" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0 text-gray-500" style="font-size:.65rem;line-height:1rem;">
									<td class="h-12 px-3 py-2 text-left lg:h-full">
										{{ frontEndDateFormat(history.created_at) }}
									</td>
									<td class="h-16 px-3 py-2 text-left lg:h-full">
										<doc-location :Division="history.division" :Cluster="history.cluster" :Office="history.office" :Type="1"></doc-location>
									</td>
									<td class="h-24 px-3 py-2 text-left lg:h-full">
										<span v-if="history.doc_notes != null"> {{ history.doc_notes }} </span>
										<span class="text-red-500" v-if="history.doc_notes == null"> No Document Notes </span>
										<br/>
										<span v-if="history.document_status != null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
											{{ history.document_status }}
										</span>
										<span class="text-red-500" v-if="history.document_status == null"> No Action </span>
									</td>
									<td class="h-16 px-3 py-2 text-left lg:h-full">
										<doc-destination v-if="history.forwarded_to" class="text-gray-500" :Destination="history.forwarded_to"></doc-destination>	
										<span v-if="!history.forwarded_to" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
											Pending
										</span>
									</td>
									<td class="flex gap-2 overflow-x-auto h-16 px-3 py-2 text-left lg:h-full">
										<div v-for="att in history.img_logs_tbl" :key="att" class="">
											<div class="px-1">
												<figure class="relative max-w-xs cursor-pointer">
													<img @click="openImageInNewTab($event)" :id="'image_'+att.id" class="object-cover opacity-90 border-b-2 border-gray-500 mb-2 hover:opacity-100" style="height:50px;width:50px;" :src="'../storage/'+att.path">
												</figure>
											</div>
										</div>

										<span class="text-red-500" v-if="history.img_logs_tbl.length == 0">
											No Attachments
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</section>

					<section class="px-3 pt-3 pb-1 flex justify-between items-center">
							<button type="button" @click="toggleParticularsDocHistory" class="focus:outline-none bg-white text-xs text-blue-400 hover:bg-blue-400 uppercase hover:shadow-lg hover:text-white border border-blue-400 rounded-full px-3 py-2 mx-0 outline-none">
								<span v-if="ToggleDocsHistory_Particulars">View Particulars <i class="fas fa-history"></i></span>
								<span v-if="!ToggleDocsHistory_Particulars">Go back <i class="fas fa-chevron-left"></i></span>
							</button>
						<div class="inline-flex gap-3 ml-auto">
							<button type="button" @click="closeModal(1)" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-3 py-2 mx-0 outline-none">
								close <i class="fas fa-times-circle"></i>
							</button>
						</div>
					</section>
				</form>
			</div>
		</modal>

	</office-layout>
</template>

<script>
    import OfficeLayout from '@/Layouts/OfficeLayout'
    import Modal from '@/Jetstream/Modal'
	import moment from 'moment'
	import UploadImages from "vue-upload-drop-images"
	import Mylib from '@/CustomFunctions/Mylib.js';
    import Pagination from '../../CustomComponents/Pagination.vue'
	import DocActions from '../../CustomComponents/DocActions.vue'
	import DocTypes from '../../CustomComponents/DocTypes.vue'
	import DocLocation from '../../CustomComponents/DocLocation.vue'
	import DocDestination from '../../CustomComponents/DocDestination.vue'
	import ParticularsList from '../../CustomComponents/ParticularsList.vue'
	
    export default {
        components: {
            OfficeLayout,
            Modal,
			UploadImages,
			Pagination,
			DocActions,
			DocTypes,
			DocLocation,
			DocDestination,
			ParticularsList,
        },
		props: ['Documents','UsersDetails'],
		data() {
			return {
				ViewingModal: false,
				LogDocumentModal: false,
				ToggleDocsHistory_Particulars: false,
				IncomingDtrackArray: [],
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				LogDocData: null,
				ToggleErrorLogForm: null,
				SearchDoc: '',
			};
		},
		methods: {
			closeModal(type){
				// ViewingModal
				if(type == 1){
					this.ViewingModal = false;
					this.SpecificDocData = [];
				// LogDocumentModal
				}else if(type == 2){
					this.LogDocumentModal = false;
					this.LogForm.logDtrackNo = null;
					this.ToggleErrorLogForm = null;
				// ForwardingModal
				}else if(type == 3){
					this.ForwardingModal = false;
				}else;
			},
			viewParticulars(data){
				console.log("viewParticulars");
				Mylib.viewParticulars(this,data);
			},
			openImageInNewTab(event){
				Mylib.openImageInNewTab(event);
			},
			frontEndDateFormat: function(date_data) {
				return Mylib.frontEndDateFormat(date_data);
        	},
			dateDifference: function(startDate,endDate) {
				return Mylib.dateDifference(startDate,endDate);
        	},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
			// Searching
			searchDocuments: function() {
				console.log("searchDocuments");
				this.$inertia.get(route('office.searchDocuments'), { SearchDoc: this.SearchDoc, RedirectComponent: 'Documents/Outgoing' }, { replace: true })
			},
			// Reset Searching
			resetSearchDocuments: function() {
				this.$inertia.get(route('office.outgoing'), { }, { })
            },
		},
		created: function(){
        }
    };
</script>
<template>
	<office-layout>
		<div class="py-6">
			<div class="w-full px-2 mx-auto sm:px-6 lg:px-8">
				<span class="text-lg font-bold text-gray-900">
					Documents History
				</span>
				<div class="lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<div class="flex-1 min-w-0">
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
							<div class="border overflow-hidden flex ">
								<input type="text" class="py-2 bg-white border-b-2 border-pink-600 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-base text-pink-600 focus:outline-none focus:ring-0" v-model="SearchDoc" placeholder="Search Docs here...">
								<button v-if="this.SearchDoc != ''" @click="searchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-pink-600 hover:bg-pink-600 hover:text-white focus:outline-none border-pink-600">
									<i class="fas fa-search"></i>
								</button>
								<button @click="FilteringModal = true" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-pink-600 hover:bg-pink-600 hover:text-white focus:outline-none border-pink-600">
									<i class="fas fa-filter"></i>
								</button>
								<vue-excel-xlsx
									:data="this.exportAll.Data"
									:columns="this.exportAll.Columns"
									:filename="'FilteredDocumentsHistoryData'"
									:sheetname="'FilteredDocumentsHistoryData'"
									class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-pink-600 hover:bg-pink-600 hover:text-white focus:outline-none border-pink-600">
									<i class="fas fa-file-download"></i>
								</vue-excel-xlsx>
								<button @click="resetSearchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-pink-600 hover:bg-pink-600 hover:text-white focus:outline-none border-pink-600">
									<i class="fas fa-window-restore"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="hidden lg:mt-0 lg:ml-4 lg:block">
						<div class="text-xs font-medium">
							<p class="text-gray-900"> Showing {{ Documents.from +'-'+ Documents.to }} Docs out of {{ Documents.total }}  </p>
							<a class="text-pink-500 hover:underline" href="#" @click="ConfirmationModal = true, exportAllDocuments()"> Export All </a>
						</div>
					</div>
				</div>

				<div class="w-full lg:flex lg:items-center lg:justify-between mt-2">
					<table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg my-5 border-2 border-pink-600 lg:border-0">
						<thead class="flex-1 sm:flex-none text-xs bg-pink-600 text-white divide-y divide-pink-800">
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
						<tbody class="flex-1 sm:flex-none bg-white divide-y divide-pink-800 lg:divide-y lg:divide-gray-200">
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
									<div class="text-xs text-pink-600">DTRAK No. {{ docs.documents_tbl.dtrack_no }}</div>
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
									<a @click="ViewingModal = true, viewParticulars(docs.documents_tbl), toggleParticularsDocHistory()" class="text-pink-500 hover:text-pink-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Show exports -->
				<div class="hidden">
					<document-exports :Documents="Documents"></document-exports>
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
					<!-- header -->
					<section class="flex flex-wrap border-b border-gray-300 px-5 items-center">
						<div class="w-full lg:w-3/4 text-gray-500">
							<p class="lg:text-2xl font-semibold">{{ SpecificDocData.doc_type }} </p>
							<p class="text-xs font-light mt-0" >Origin: {{ this.OriginFname }}  {{ this.OriginLname }} </p>
						</div>
						<div class="w-full lg:w-1/4 ">
							<div class="text-xs text-gray-500">Dtrack No. <span class="text-pink-500">{{ SpecificDocData.dtrack_no }}</span> </div>
							<div class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Request'">PR No.
								<span class="text-pink-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_from }}</span>
							</div>
							<div class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Order'">PO No.
								<span class="text-pink-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_to }}</span>
							</div>
							<div class="text-xs text-gray-500 font-light ml-auto">Created On: {{ frontEndDateFormat(SpecificDocData.created_at) }}</div>	
						</div>
					</section>

					<!-- Particulars -->
					<section class="px-5 mt-2" v-if="!ToggleDocsHistory_Particulars">
						<particulars-list :Particulars="SpecificDocData.documents_particulars_tbl"></particulars-list>
					</section>

					<!-- History -->
					<section class="px-5 mt-2" v-if="ToggleDocsHistory_Particulars">
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
										<span v-html=" frontEndDateFormat(history.created_at) "></span>
									</td>
									<td class="h-16 px-3 py-2 text-left lg:h-full">
										<doc-location :Division="history.division" :Cluster="history.cluster" :Office="history.office" :Type="1"></doc-location>
									</td>
									<td class="h-24 px-3 py-2 text-left lg:h-full">
										<span v-if="history.doc_notes != null"> {{ history.doc_notes }} </span>
										<span class="text-red-500" v-if="history.doc_notes == null"> No Document Notes </span>
										<br/>
										<span v-if="history.document_status != null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
											{{ history.document_status }}
										</span>
										<span class="text-red-500" v-if="history.document_status == null"> No Action </span>
									</td>
									<td class="h-16 px-3 py-2 text-left lg:h-full">
										<doc-destination v-if="history.forwarded_to" :Destination="history.forwarded_to"></doc-destination>	
										<span v-if="!history.forwarded_to" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
											Pending
										</span>
									</td>
									<td class="flex gap-2 overflow-x-auto h-16 px-3 py-2 text-left lg:h-full">
										<div v-for="att in history.img_logs_tbl" :key="att" class="">
											<figure class="relative max-w-xs cursor-pointer">
												<img @click="openImageInNewTab($event)" :id="'image_'+att.id" class="object-cover opacity-90 border-b-2 border-gray-500 mb-2 hover:opacity-100" style="height:50px;width:50px;" :src="'../storage/'+att.path">
											</figure>
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
							<button type="button" @click="toggleParticularsDocHistory" class="focus:outline-none bg-white text-xs text-pink-400 hover:bg-pink-400 uppercase hover:shadow-lg hover:text-white border border-pink-400 rounded-full px-3 py-2 mx-0 outline-none">
								<span v-if="ToggleDocsHistory_Particulars">Vew Particulars <i class="fas fa-history"></i></span>
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

		<!-- Modal for Filtering Document -->
		<modal :show="FilteringModal" max-width="sm">
			<div class="py-2">
				<form>
					<!-- header -->
					<section class="flex flex-wrap border-b mb-2 border-gray-300 px-5 items-center">
						<div class="w-full lg:w-3/4 text-gray-500">
							<p class="lg:text-2xl font-semibold"> Filters </p>
							<p class="text-xs font-light mt-0 mb-2" > Apply filters to see changes </p>
						</div>
					</section>

					<section class="flex flex-wrap border-b border-gray-300 px-5 items-center">
						<div class="block text-pink-500 mb-2 w-full">
							<label for="dateFrom" class="text-xs">Date From</label>
							<input name="dateFrom" type="date" v-model="FilterDocForm.DateFrom" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
						</div>

						<div class="block text-pink-500 mb-2 w-full">
							<label for="dateTo" class="text-xs">Date To</label>
							<input name="dateTo" type="date" v-model="FilterDocForm.DateTo" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
						</div>

						<div class="block text-pink-500 mb-2 w-full">
							<label for="doctype" class="text-xs">Document Type</label>
							<select name="doctype" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" id="doctype" v-model="FilterDocForm.DocType">
								<doc-types></doc-types>
							</select>
						</div>

					</section>
					<section class="px-3 pt-3 pb-1 flex justify-between items-center">
						<div class="inline-flex gap-3 ml-auto">
							<button type="button" @click="closeModal(5),submitFilteringDocumentsModal()" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none">
								Apply Filters <i class="fas fa-filter"></i>
							</button>
							<button type="button" @click="closeModal(5)" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-3 py-2 mx-0 outline-none">
								close <i class="fas fa-times-circle"></i>
							</button>
						</div>
					</section>
				</form>
			</div>
		</modal>

		<!-- Modal for Filtering Document -->
		<modal :show="ConfirmationModal" max-width="sm">
			<div class="py-4">
				<section class="flex flex-wrap mb-2 px-5 items-center">
					<div class="w-full text-gray-500">
						<p class="lg:text-xl font-semibold text-center"> Do you want to export all documents history? </p>
					</div>
				</section>
				<section class="px-3 pt-3 pb-1 flex justify-between items-center">
					<div v-if="showConfirmationExportAll == true">
						<vue-excel-xlsx
							:data="this.exportAll.Data"
							:columns="this.exportAll.Columns"
							:filename="'DocumentsHistory_AllDocs'"
							:sheetname="'DocumentsHistory_AllDocs'"
							>
							<button type="button" @click="ConfirmationModal = false" class="focus:outline-none bg-white text-xs text-pink-500 hover:bg-pink-500 uppercase hover:shadow-lg hover:text-white border border-pink-500 rounded-full px-3 py-1 mx-0 outline-none">
								Yes, export it. <i class="fas fa-check"></i>
							</button>
						</vue-excel-xlsx>
					</div>
					<div class="inline-flex gap-3 ml-auto">
						<button type="button" @click="ConfirmationModal = false" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-3 py-1 mx-0 outline-none">
							Cancel <i class="fas fa-times-circle"></i>
						</button>
					</div>
				</section>

			</div>
		</modal>
	</office-layout>
</template>

<script>
    import OfficeLayout from '@/Layouts/OfficeLayout'
    import Modal from '@/Jetstream/Modal'
	import UploadImages from "vue-upload-drop-images"
	import moment from 'moment'
	import Mylib from '@/CustomFunctions/Mylib.js';	
    import Pagination from '../../CustomComponents/Pagination.vue'
	import DocActions from '../../CustomComponents/DocActions.vue'
	import DocTypes from '../../CustomComponents/DocTypes.vue'
	import DocLocation from '../../CustomComponents/DocLocation.vue'
	import DocDestination from '../../CustomComponents/DocDestination.vue'
	import ParticularsList from '../../CustomComponents/ParticularsList.vue'
	import DocumentExports from '../../CustomComponents/DocumentExports.vue'

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
			DocumentExports
        },
		props: ['Documents','UsersDetails'],
		data() {
			return {
				SearchDoc: "",
				showConfirmationExportAll: false,
				ExportButton: false,
				ConfirmationModal: false,
				ViewingModal: false,
				FilteringModal: false,
				CreateDocumentModal: false,
				ToggleDocsHistory_Particulars: true,
				preview: null,
				image: null,
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				SpecificUser: [],
				FilterDocForm: this.$inertia.form({
					DateFrom: null,
					DateTo: null,
					EndUser: null,
					Division: null,
					Cluster: 0,
					Office: 0,
					DocType: null,
				}),
				Division_List: [],
				Office_List: [],
				Cluster_List: [],
				SpecificUser: [],
				exportAll:{
					Data: [],
					Columns: null,
				}
			};
		},
		methods: {
			closeModal(type){
				Mylib.closeModal(this,type);
				this.ToggleDocsHistory_Particulars = true;
			},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
			openImageInNewTab(event){
				Mylib.openImageInNewTab(event);
			},
			viewParticulars(data){
				Mylib.viewParticulars(this,data);
			},
			frontEndDateFormat: function(date_data) {
				return Mylib.frontEndDateFormat(date_data);
        	},
			dateDifference: function(startDate,endDate) {
				return Mylib.dateDifference(startDate,endDate);
        	},
			// Methods for Dependent Dropdown
            getOfficesDivision: function(){
				Mylib.getOfficesDivision(this);
            },
			getOfficesCluster: function(cluster,division) {
				console.log("getOfficesCluster");
				console.log(cluster+' '+division);
				Mylib.getOfficesCluster(this,cluster,division);
				this.getOffices(cluster,division);
            },
			getOffices: function(cluster,division) {
				console.log("getOffices");
				Mylib.getOffices(this,cluster,division);
            },
			getSpecificUser: function() {
				console.log(this.FilterDocForm.Division);
				console.log(this.FilterDocForm.Cluster);
				console.log(this.FilterDocForm.Office);
				console.log("SpecificUser");
                axios.get('/getSpecificUser',{
                 params: {
                   division_id: this.FilterDocForm.Division,
                   cluster_id: this.FilterDocForm.Cluster,
                   office_id: this.FilterDocForm.Office,
                 }
              }).then(function(response){
                    this.SpecificUser = response.data;
					console.log(response.data);
                }.bind(this));
            },
			exportDocuments: function() {
				// Push Columns to Array
				this.exportAll.Columns = [
					{
						label: "DTRAK No.",
						field: "dtrack_id_fk",
					},
					{
						label: "Created/Received",
						field: "created_at",
					},
					{
						label: "Origin",
						field: "origin",
					},
					{
						label: "Document",
						field: "doc_type",
					},
					{
						label: "Particulars",
						field: "documents_particulars_tbl_count",
					},
					{
						label: "Forwarded",
						field: "updated_at",
					},
					{
						label: "Destination",
						field: "destination",
					},
					{
						label: "Assessment",
						field: "assessment",
					},
				];

				for(var x=0; x < this.Documents.data.length; x++){
					this.exportAll.Data.push({
						dtrack_id_fk: this.Documents.data[x].dtrack_id_fk,
						created_at: this.frontEndDateFormat(this.Documents.data[x].created_at),
						origin: this.Documents.data[x].documents_tbl.users_details.fname+' '+this.Documents.data[x].documents_tbl.users_details.lname,
						doc_type: this.Documents.data[x].doc_type,
						documents_particulars_tbl_count: this.Documents.data[x].documents_tbl.documents_particulars_tbl_count,
						updated_at: this.frontEndDateFormat(this.Documents.data[x].updated_at),
						destination: Mylib.locationForExporting(this.Documents.data[x].forwarded_to),
						assessment: this.dateDifference(this.Documents.data[x].created_at,this.Documents.data[x].updated_at),
					});
				}

				console.log("this.Documents.data");
				console.log(this.Documents.data);
				console.log(this.exportAll.Columns);
			},
			exportAllDocuments: function() {
				console.log("exportAllDocuments");
				axios.get('/exportAllDocuments',{
				}).then(function(response){
					// Push Data Fields to Array
					for(var x=0; x < response.data.length; x++){
						this.exportAll.Data.push({
							dtrack_id_fk: response.data[x].dtrack_id_fk,
							created_at: this.frontEndDateFormat(response.data[x].created_at),
							origin: response.data[x].documents_tbl.users_details.fname+' '+response.data[x].documents_tbl.users_details.lname,
							doc_type: response.data[x].doc_type,
							documents_particulars_tbl_count: response.data[x].documents_tbl.documents_particulars_tbl_count,
							updated_at: this.frontEndDateFormat(response.data[x].updated_at),
							destination: Mylib.locationForExporting(response.data[x].forwarded_to),
							assessment: this.dateDifference(response.data[x].created_at,response.data[x].updated_at),
						});
					}
					// Show confirm btn when All Data and Columns are pushed
					this.showConfirmationExportAll = true;
				}.bind(this));
			},
			// Searching
			searchDocuments: function() {
				console.log("searchDocuments");
				this.$inertia.get(route('office.searchDocuments'), { SearchDoc: this.SearchDoc, RedirectComponent: 'Documents/DocumentsHistory' }, { replace: true })
			},
			resetSearchDocuments: function() {
				this.$inertia.get(route('office.docsHistory'), { }, { })
            },
			submitFilteringDocumentsModal: function() {
				console.log(this.FilterDocForm.DateFrom);
				console.log(this.FilterDocForm.DateTo);
				console.log(this.FilterDocForm.Division);
				console.log(this.FilterDocForm.Cluster);
				console.log(this.FilterDocForm.Office);
				console.log(this.FilterDocForm.EndUser);
				console.log("getFilteredDocumentsHistory");
				this.$inertia.get(route('office.getFilteredDocumentsHistory'), {
					date_from: this.FilterDocForm.DateFrom, 
					date_to: this.FilterDocForm.DateTo, 
					doc_type: this.FilterDocForm.DocType
				}, { replace: true })
				.then(function(response){
					this.ExportButton = true;
					console.log(this.ExportButton);
				});
            },
			
		},
		created: function(){
            this.getOfficesDivision();
            this.exportDocuments();
        },
    };
</script>

<template>
	<office-layout>
		<div class="py-6">
			<div class="w-full px-2 mx-auto sm:px-6 lg:px-8">
				<span class="text-lg font-bold text-gray-900">
					My Documents
				</span>
				<div class="lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<div class="flex-1 min-w-0">
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
							<div class="border overflow-hidden flex ">
								<input type="text" class="py-2 bg-white border-b-2 border-blue-600 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-base text-blue-600 focus:outline-none focus:ring-0" v-model="SearchDoc" placeholder="Search Docs here...">
								<button v-if="this.SearchDoc != ''" @click="searchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white focus:outline-none border-blue-600">
									<i class="fas fa-search"></i>
								</button>
								<button @click="resetSearchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white focus:outline-none border-blue-600">
									<i class="fas fa-window-restore"></i>
								</button>
								<button @click="CreateDocumentModal = true" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white focus:outline-none border-blue-600 lg:hidden">
									<i class="fas fa-file-medical"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="hidden lg:mt-0 lg:ml-4 lg:block">
						<span class="lg:ml-3">
							<button @click="CreateDocumentModal = true" type="button" class="inline-flex items-center w-full px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-white text-blue-600 hover:bg-blue-700 hover:text-white focus:outline-none border-blue-700">
								<i class="fas fa-file-signature"></i> &nbsp;	
								Create Docs
							</button>
						</span>
					</div>
				</div>

				<div class="w-full lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg my-5 border-2 border-blue-600 lg:border-0">
						<thead class="flex-1 sm:flex-none text-xs bg-blue-600 text-white divide-y divide-blue-800">
							<tr v-show="Documents.data.length > 0" v-for="(item, index) in Documents.data" :key="index" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-24 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Previous</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Current</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Destination</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
							<tr v-if="Documents.data.length == 0" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-24 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Previous</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Current</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Destination</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
						</thead>
						<tbody class="flex-1 sm:flex-none bg-white divide-y divide-blue-800 lg:divide-y lg:divide-gray-200">
							<tr v-if="!Documents.data.length">
								<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
									No Data Available
								</td>
							</tr>
							<tr v-show="Documents.data.length > 0" v-for="(item, index) in Documents.data" :key="index" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<td class="h-24 px-3 py-2 text-left lg:h-full">
									<div class="text-xs text-gray-900">{{ item.doc_type }} </div>
									<div class="text-xs text-gray-500">{{ item.documents_particulars_tbl.length }} Particulars</div>
									<div class="text-xs text-blue-600">DTRAK No. {{ item.dtrack_no }}</div>
									<span v-if="item.doc_current_status == 'Accomplished PR - Processing for PO'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
										Accomplished PR
									</span>
									<span v-if="item.doc_current_status == 'Accomplished PO'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
										Accomplished PO
									</span>		
								</td>

								<!-- if there are exactly 2 ka logs -->
								<td v-if="item.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-red-500" v-if="item.documents_status_log_tbl[1] != null" :Division="item.documents_status_log_tbl[1].division" :Cluster="item.documents_status_log_tbl[1].cluster" :Office="item.documents_status_log_tbl[1].office" :Type="1"></doc-location>
								</td>
								<td v-if="item.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-yellow-500" v-if="item.documents_status_log_tbl[0] != null" :Division="item.documents_status_log_tbl[0].division" :Cluster="item.documents_status_log_tbl[0].cluster" :Office="item.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="item.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-destination class="text-pink-500" v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to != null" :Destination="item.documents_status_log_tbl[0].forwarded_to"></doc-destination>
									<p v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to == null">
										<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
											Pending
										</span>
									</p>
								</td>

								<!-- if there are exactly 1 ka logs -->
								<td v-if="item.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-red-500" v-if="item.documents_status_log_tbl[0] != null" :Division="item.documents_status_log_tbl[0].division" :Cluster="item.documents_status_log_tbl[0].cluster" :Office="item.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="item.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-yellow-500" v-if="item.documents_status_log_tbl[0] != null" :Division="item.documents_status_log_tbl[0].division" :Cluster="item.documents_status_log_tbl[0].cluster" :Office="item.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="item.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 text-left lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-destination class="text-pink-500" v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to != null" :Destination="item.documents_status_log_tbl[0].forwarded_to"></doc-destination>
								</td>

								<td class="h-12 px-3 py-2 text-left lg:h-full lg:text-center text-sm font-medium">
									<a @click="ViewingModal = true, viewParticulars(item)" class="text-blue-600 hover:text-blue-800 cursor-pointer">View <i class="fas fa-eye"></i> </a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="py-2 align-middle inline-block min-w-full">
					<pagination :links="Documents.links" :current_page="Documents.current_page" :prev_url="Documents.prev_page_url" :next_url="Documents.next_page_url" :total_page="Documents.last_page" :path="Documents.path"></pagination>
				</div>
			</div>
		</div>

		<!-- Modal for Creating Document -->
		<modal :show="CreateDocumentModal" max-width="fullLG">
			<div class="py-2 w-full">
				<!-- header -->
				<section class="border-b border-gray-300 px-5 flex justify-between items-center">
					<div class="text-gray-500">
						<span class="text-2xl font-semibold">Create documents</span><br>
						<span class="text-xs font-light">(This is for creating document)</span>
					</div>

					<button @click="closeModal(4)" class="rounded-md text-gray-300 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-red">
					<span class="sr-only">Close panel</span>
					<!-- Heroicon name: outline/x -->
					<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
					</button>
				</section>
			</div>
			<form @submit.prevent="submitCreateDocumentModal" enctype="multipart/form-data">
				<!-- Modal Page 1 -->
				<div class="flex flex-wrap" v-show="CreateDocForm.CreateDocPage == 1">
					<div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-5 py-2">
						<div class="block text-purple-500 mb-2">
							<label for="dtrak" class="text-base">DTRAK No. </label>
							<input required ref="dtrak" name="dtrak" type="text" v-model="CreateDocForm.CreateDtrackNo" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
						</div>

						<div class="block text-purple-500 mb-2">
							<label for="doctype" class="text-base">Document Type</label>
							<select name="doctype" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" id="doctype" v-model="CreateDocForm.CreateDocType" required>
								<doc-types></doc-types>
							</select>
						</div>

						<div class="block text-purple-500 my-2 text-base">
							Destination
						</div>

						<!-- Official Destinations -->
						<div class="grid grid-cols-6 gap-2">
						<div class="col-span-6 sm:col-span-3 text-gray-500">
							<label for="division" class="text-xs">Division</label>
							<select id="division" name="division" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocDivisionData" @change='getOfficesCluster(CreateDocForm.CreateDocClusterData,CreateDocForm.CreateDocDivisionData),getSpecificUser()' required>
								<option v-for='divData in Division_List' :key="divData" :value='divData.id'>{{ divData.name }}</option>
							</select>
						</div>

						<div class="col-span-6 sm:col-span-3 text-gray-500" v-if="CreateDocForm.CreateDocDivisionData == 2 || CreateDocForm.CreateDocDivisionData == 3">
							<label for="cluster" class="text-xs">Section/Cluster</label>
							<select id="cluster" name="cluster" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocClusterData" @change='getOffices(CreateDocForm.CreateDocClusterData,CreateDocForm.CreateDocDivisionData),getSpecificUser()'>
								<option v-for='clusData in Cluster_List' :key="clusData" :value='clusData.id'>{{ clusData.name }}</option>
							</select>
						</div>

						<div v-bind:class="{ 'col-span-6 sm:col-span-3 text-gray-500': CreateDocForm.CreateDocDivisionData != 2 || CreateDocForm.CreateDocDivisionData != 3, 'col-span-6 sm:col-span-6 text-gray-500': CreateDocForm.CreateDocDivisionData == 2 || CreateDocForm.CreateDocDivisionData == 3}">
							<label for="office" class="text-xs">Office</label>
							<select id="office" name="office" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocOfficeData" @change="getSpecificUser()" required>
								<option v-for='officeData in Office_List' :key="officeData" :value='officeData.id'>{{ officeData.name }}</option>
							</select>
						</div>
						</div>
						<div class="block text-gray-500 mb-2">
							<label for="doctype" class="text-xs">Specific User</label>
							<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model='CreateDocForm.SpecificUserData' required>
								<option v-for="option in SpecificUser" :key="option.id" :value="option.id">
									{{ option.fname +' '+ option.lname }}
								</option>
							</select>
						</div>

						<div class="block text-gray-500 mb-2">
							<label for="doctype" class="text-xs">Action</label>
							<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model='CreateDocForm.CreateDocAction' required>
								<doc-actions></doc-actions>
							</select>
						</div>
					</div>
					
					<div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-5 py-2">
						<div class="block text-gray-500 my-3">
							<!-- Toggle A -->
							<label for="toogleA" class="flex items-center cursor-pointer">
								<!-- toggle -->
								<div class="relative">
									<!-- input -->
									<input id="toogleA" type="checkbox" class="sr-only" v-model="CreateDocForm.AddNote"/>
									<!-- line -->
									<div class="w-10 h-4 bg-gray-100 rounded-full shadow-inner"></div>
									<!-- dot -->
									<div class="dot absolute w-6 h-6 border-1 bg-gray-500 rounded-full shadow-md -left-1 -top-1 transition"></div>
								</div>
								<!-- label -->
								<div class="ml-3 font-medium text-xs">
									<span v-if="CreateDocForm.AddNote == true" class="text-green-500">Please fill-out note for notes/actions/remarks</span>
									<span v-if="CreateDocForm.AddNote == false" class="text-red-500">Attach a note?</span>
								</div>
							</label>
						</div>

						<!-- Has Note -->
						<div class="block text-gray-500 my-2" v-if="CreateDocForm.AddNote == true">
							<textarea id="about" type="text" v-model="CreateDocForm.CreateDocNote" name="note" rows="5" class="shadow-sm focus:ring-indigo-500 focus:ring-1 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Place your comments here..."></textarea>
						</div>

						<!-- Has Attachment -->
						<div class="block text-gray-500 my-3">
							<!-- Toggle A -->
							<label for="toogleB" class="flex items-center cursor-pointer">
								<!-- toggle -->
								<div class="relative">
									<!-- input -->
									<input id="toogleB" type="checkbox" class="sr-only" v-model="CreateDocForm.AddAttachment"/>
									<!-- line -->
									<div class="w-10 h-4 bg-gray-100 rounded-full shadow-inner"></div>
									<!-- dot -->
									<div class="dot absolute w-6 h-6 border-1 bg-gray-500 rounded-full shadow-md -left-1 -top-1 transition"></div>
								</div>
								<!-- label -->
								<div class="ml-3 font-medium text-xs">
									<span v-if="CreateDocForm.AddAttachment == true" class="text-green-500">Add files to attach</span>
									<span v-if="CreateDocForm.AddAttachment == false" class="text-red-500">Attach a file?</span>
								</div>
							</label>
						</div>

						<div class="block text-gray-500 my-2" v-if="CreateDocForm.AddAttachment == true">
							<UploadImages @change="handleImages" :max="5" maxError="Max files exceed" fileError="Please upload an image file. (.PNG, .JPEG, .JPG)" uploadMsg="Add files to attach"/>
						</div>

					</div>
				</div>

				<!-- Modal Page 2 -->
				<div class="block w-full mb-4 px-3" v-if="CreateDocForm.CreateDocPage > 1">
					<div class="text-gray-500 font-medium text-lg my-2 inline-flex ml-auto">
						Add Particulars
					</div>
					<div class="overflow-hidden border border-gray-200 ">
						<table class="table-auto min-w-full divide-y divide-gray-200">
							<thead>
								<tr class="font-bold">
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Item
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Qty
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Unit
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Amount
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Purpose
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs text-gray-500 uppercase tracking-wider">
										Actions
									</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200 text-purple-500 text-xs overflow-y-auto h-10">
								<tr class="cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50" v-for="(particulars_data, index) in this.CreateDocForm.CreateParticularsArray" :key="particulars_data.id">
									<td class="px-2 py-1">
										<input v-model="particulars_data.item" type="text" class="py-1 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
									</td>
									<td class="px-2 py-1">
										<input v-model="particulars_data.qty" type="text" class="py-1 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
									</td>
									<td class="px-2 py-1">
										<input v-model="particulars_data.unit" type="text" class="py-1 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
									</td>
									<td class="px-2 py-1">
										<input v-model="particulars_data.amt" type="text" class="py-1 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
									</td>
									<td class="px-2 py-1">
										<input v-model="particulars_data.purpose" type="text" class="py-1 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
									</td>
									<td class="pt-2 inline-flex gap-2">
										<button @click="addRow()" type="button" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-1 py-1 mx-0 outline-none">
											&nbsp;<i class="fas fa-plus-circle"></i>&nbsp;
										</button>
										<button v-if="this.CreateDocForm.CreateParticularsArray.length > 1" @click="removeRow(index)" type="button" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-1 py-1 mx-0 outline-none">
											&nbsp;<i class="fas fa-trash"></i>&nbsp;
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Modal Footer   border-t border-gray-300 -->
				<div class="py-2 w-full">
					<section class="px-3 pt-3 pb-1 flex justify-between items-center">
						<div class="inline-flex gap-3 ml-auto">
							<button v-if="CreateDocForm.CreateDocType != null && CreateDocForm.CreateDocType == 'Purchase Request'" type="button" @click="CreateDocForm.CreateDocPage = 2" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none disabled:opacity-50" :hidden="CreateDocForm.CreateDocPage > 1">
								Add Particulars <i class="fas fa-clipboard-list"></i>
							</button>

							<button v-if="CreateDocForm.CreateDocPage == 2" type="button" @click="CreateDocForm.CreateDocPage = 1" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none disabled:opacity-50">
								Back <i class="fas fa-chevron-left"></i>
							</button>

							<button v-if="isCreateDocFormComplete" type="submit" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none">
								Submit <i class="fas fa-paper-plane"></i>
							</button>
						</div>
					</section>
				</div>
			</form>
		</modal>

		<!-- Modal for Viewing Document -->
		<modal :show="ViewingModal" >
			<div class="py-2">
				<form>
					<!-- header -->
					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="text-gray-500">
							<span class="text-2xl font-semibold">{{ SpecificDocData.doc_type }} </span><br>
							<span class="text-xs font-light" >Origin: {{ this.OriginFname }}  {{ this.OriginLname }} </span><br>
						</div>
						<div class="block ml-auto">
							<div class="text-xs text-gray-500">Dtrack No. <span class="text-green-500">{{ SpecificDocData.dtrack_no }}</span> </div>
							<span class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Request'">PR No. <span class="text-green-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_from }}</span>	</span><br>
							<span class="text-xs text-gray-500 font-light" v-if="SpecificDocData.documents_mutation_log_tbl != null && SpecificDocData.doc_type == 'Purchase Order'">PO No. <span class="text-green-500">{{ SpecificDocData.documents_mutation_log_tbl.doc_to }}</span>	</span><br>
							<div class="text-xs text-gray-500 font-light ml-auto">Created On: {{ frontEndDateFormat(SpecificDocData.created_at) }}</div>	
						</div>
					</section>
					<!-- Particulars -->
					<section class="flex gap-x-4 px-5 mt-2 overflow-x-auto" v-if="!ToggleDocsHistory_Particulars">
						<!-- This example requires Tailwind CSS v2.0+ -->
						<div class="py-2 align-middle inline-block min-w-full">
							<section class="border-b text-gray-500 flex justify-between items-center">
								<span class="text-1xl font-semibold">Particulars</span><br>
							</section>
							<div class="overflow-hidden border border-gray-200 ">
								<table class="table-auto min-w-full divide-y divide-gray-200">
									<thead class="bg-gray-50">
										<tr>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												No
											</th>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Item
											</th>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Qty
											</th>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Unit
											</th>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Amount
											</th>
											<th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Purpose
											</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200 text-purple-500 text-xs">
										<tr v-for="(item, index) in SpecificDocData.documents_particulars_tbl" :key="item.created_at" class="hover:bg-purple-300 hover:text-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50">
											<td class="px-3 py-1">{{ forIndex(index) }}</td>
											<td class="px-3 py-1">{{ item.Item }}</td>
											<td class="px-3 py-1">{{ item.item_qty }}</td>
											<td class="px-3 py-1">{{ item.item_unit }}</td>
											<td class="px-3 py-1">₱ {{ formatAmount(item.item_amount) }}</td>
											<td class="px-3 py-1">{{ item.purpose }}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>

					<!-- History -->
					<section class="px-5 mt-2 overflow-x-auto" v-if="ToggleDocsHistory_Particulars">
						<table class="table-auto min-w-full divide-y divide-gray-200">
							<thead class="text-xs bg-gray-50">
								<tr>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Date
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Location
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Remarks/Notes & Action
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Destination
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Attachments
									</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								<tr v-for="history in SpecificDocData.documents_status_log_tbl" :key="history" class="text-gray-500" style="font-size:.65rem;line-height:1rem;">
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-html=" frontEndDateFormat(history.created_at) "></span>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<doc-location :Division="history.division" :Cluster="history.cluster" :Office="history.office" :Type="1"></doc-location>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-if="history.doc_notes != null"> {{ history.doc_notes }} </span>
										<span class="text-red-500" v-if="history.doc_notes == null"> No Document Notes </span>
										<br/>
										<span v-if="history.document_status != null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
											{{ history.document_status }}
										</span>
										<span class="text-red-500" v-if="history.document_status == null"> No Action </span>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<doc-destination v-if="history.forwarded_to" :Destination="history.forwarded_to"></doc-destination>	
										<span v-if="!history.forwarded_to" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
											Pending
										</span>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<div v-for="att in history.img_logs_tbl" :key="att" class="inline-flex gap-x-2">
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
        },
		props: ['Documents','UsersDetails'],
		data() {
			return {
				SearchDoc: "",
				ViewingModal: false,
				CreateDocumentModal: false,
				ToggleDocsHistory_Particulars: true,
				CreateDocForm: this.$inertia.form({
					CreateDtrackNo: null,
					CreateDocType: null,
					CreateDocDivisionData: null,
					CreateDocOfficeData: 0,
					CreateDocClusterData: 0,
					CreateDocAction: false,
					AddNote: false,
					AddAttachment: false,
					CreateDocNote: null,
					SpecificUserData: null,
					CreateParticularsArray: [
						{
							item: '',
							qty: '',
							unit: '',
							amt: '',
							purpose: '',
						}
					],
					CreateDocfile: [],
					CreateDocImgLogs: [],
					CreateDocPage: 1,
				}),
				SearchDoc: '',
				preview: null,
				image: null,
				preview_list: [],
				image_list: [],
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				Division_List: [],
				Office_List: [],
				Cluster_List: [],
				SpecificUser: [],

			};
		},
		computed: {
			isCreateDocFormComplete () {
				if(this.CreateDocForm.CreateDocType == "Purchase Request"){
					if(this.CreateDocForm.CreateParticularsArray[0].item && this.CreateDocForm.CreateParticularsArray[0].qty && this.CreateDocForm.CreateParticularsArray[0].unit && this.CreateDocForm.CreateParticularsArray[0].amt && this.CreateDocForm.CreateParticularsArray[0].purpose){
						console.log("PR");
						return this.CreateDocForm.CreateParticularsArray[0].purpose;
					}else{
						return false;
					}
				}else;
				
				if(this.CreateDocForm.CreateDocType != "Purchase Request"){
					console.log("Not PR");
					if(this.CreateDocForm.CreateDtrackNo && this.CreateDocForm.CreateDocType  && this.CreateDocForm.CreateDocDivisionData && this.CreateDocForm.CreateDocAction){
						return this.CreateDocForm.CreateDtrackNo && this.CreateDocForm.CreateDocType  && this.CreateDocForm.CreateDocDivisionData && this.CreateDocForm.CreateDocAction;
					}else{
						return false;
					}
				}else;
			}
		},
		methods: {
			closeModal(type){
				Mylib.closeModal(this,type);
				this.ToggleDocsHistory_Particulars = true;
			},
			forIndex(index) {
				return index+1
			},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
			viewDocsHistory(){
				console.log("viewDocsHistory");
			},
			openImageInNewTab(event){
				Mylib.openImageInNewTab(event);
			},
			viewParticulars(data){
				Mylib.viewParticulars(this,data);
			},
			formatAmount(value) {
				return Mylib.formatAmount(value);
			},
			frontEndDateFormat: function(date_data) {
				return Mylib.frontEndDateFormat(date_data);
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
				// console.log(cluster,division);
				Mylib.getOffices(this,cluster,division);
            },
			getSpecificUser: function() {
				console.log("SpecificUser");
                axios.get('/getSpecificUser',{
                 params: {
                   division_id: this.CreateDocForm.CreateDocDivisionData,
                   cluster_id: this.CreateDocForm.CreateDocClusterData,
                   office_id: this.CreateDocForm.CreateDocOfficeData,
                 }
              }).then(function(response){
                    this.SpecificUser = response.data;
					console.log(response.data);
                }.bind(this));
            },
			getMutatedDocument: function(DtrackNo) {
				console.log("getMutatedDocument");
				axios.get('/getMutatedDocument',{
					params: {
						DtrackNo: DtrackNo,
					}
				}).then(function(response){
				this.SpecificDocData = response.data;
				}.bind(this));
            },
			handleImages(files){
				console.log("yawa");
				for(var i=0;i<files.length;i++){
					this.CreateDocForm.CreateDocfile.push(files[i]);
				}
				console.log(this.CreateDocForm.CreateDocfile);
				if(files.length > this.CreateDocForm.CreateDocfile.length || files.length < this.CreateDocForm.CreateDocfile.length){
					this.CreateDocForm.CreateDocfile = [];
					for(var i=0;i<files.length;i++){
						this.CreateDocForm.CreateDocfile.push(files[i]);
					}
					console.log(this.CreateDocForm.CreateDocfile);
				}
			},
			nextStep(page) {
				return this.CreateDocForm.CreateDocPage = page;
			},
			addRow(){
				var my_object = {
					item:this.CreateDocForm.CreateParticularsArray.item,
					qty:this.CreateDocForm.CreateParticularsArray.qty,
					unit:this.CreateDocForm.CreateParticularsArray.unit,
					amt:this.CreateDocForm.CreateParticularsArray.amt,
					purpose: this.CreateDocForm.CreateParticularsArray.purpose,
				};
				
				this.CreateDocForm.CreateParticularsArray.push(my_object)

				this.CreateDocForm.CreateParticularsArray.item = '';
				this.CreateDocForm.CreateParticularsArray.qty = '';
				this.CreateDocForm.CreateParticularsArray.unit = '';
				this.CreateDocForm.CreateParticularsArray.amt = '';
				this.CreateDocForm.CreateParticularsArray.purpose = '';
				console.log(this.CreateDocForm.CreateParticularsArray);
			},
			removeRow: function (index) {
				console.log(index);
				this.CreateDocForm.CreateParticularsArray.splice(index, 1);
			},
			// Searching
			searchDocuments: function() {
				console.log("searchDocuments");
				this.$inertia.get(route('office.searchDocuments'), { SearchDoc: this.SearchDoc, RedirectComponent: 'Documents/MyDocuments' }, { replace: true })
			},
			// Reset Searching
			resetSearchDocuments: function() {
				this.$inertia.get(route('office.mydocs'), { }, { })
            },
			// Submits
			submitCreateDocumentModal() {
				console.log("CreateDocForm");
				this.$inertia.post(route('office.createdoc'), this.CreateDocForm, {
					forceFormData: true,
					onSuccess: (res) => this.CreateDocumentModal = false,
					onFinish: () => this.CreateDocForm.reset(),
				}).then(function (response) {
					console.log(response);
            	}.bind(this));
			},
		},
		created: function(){
            this.getOfficesDivision();
        },
    };
</script>

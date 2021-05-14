<template>
	<office-layout>
		<div class="py-6">
			<div class="w-full px-2 mx-auto sm:px-6 lg:px-8">
				<span class="text-lg font-bold text-gray-900">
					Logged Documents
				</span>
				<div class="lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<div class="flex-1 min-w-0">
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
							<div class="border overflow-hidden flex ">
								<input type="text" class="py-2 bg-white border-b-2 border-purple-600 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-base text-purple-600 focus:outline-none focus:ring-0" v-model="SearchDoc" placeholder="Search Docs here...">
								<button v-if="this.SearchDoc != ''" @click="searchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-purple-600 hover:bg-purple-600 hover:text-white focus:outline-none border-purple-600">
									<i class="fas fa-search"></i>
								</button>
								<button @click="resetSearchDocuments()" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-purple-600 hover:bg-purple-600 hover:text-white focus:outline-none border-purple-600">
									<i class="fas fa-window-restore"></i>
								</button>
								<button @click="LogDocumentModal = true" class="flex items-center justify-center px-4 py-2 border-b-2 bg-white text-purple-600 hover:bg-purple-600 hover:text-white focus:outline-none border-purple-600 lg:hidden disabled:text-gray-500" :disabled="IncomingDocuments.length == 0">
									<i class="fas fa-file-import"></i> &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ IncomingDocuments.length }}</div>
								</button>
							</div>
						</div>
					</div>
					<div class="hidden lg:mt-0 lg:ml-4 lg:block">
						<span class="lg:ml-3">
							<button v-if="IncomingDocuments.length > 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-white text-purple-600 hover:bg-purple-700 hover:text-white focus:outline-none border-purple-700">
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs  
							</button>
 
							<button v-if="IncomingDocuments.length == 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-gray-500 text-white focus:outline-none border-gray-700" disabled>
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ IncomingDocuments.length }}</div>
							</button>
							
						</span>
					</div>
				</div>

				<div class="w-full lg:flex lg:items-center lg:justify-between mt-2 mb-2">
					<table class="w-full flex flex-row flex-no-wrap sm:bg-white overflow-hidden sm:shadow-lg my-5 border-2 border-purple-600 lg:border-0">
						<thead class="flex-1 sm:flex-none text-xs bg-purple-600 text-white divide-y divide-purple-800">
							<tr v-show="Documents.data.length > 0" v-for="docs in Documents.data" :key="docs" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-24 px-3 py-2 text-left lg:h-full">End-User</th>
								<th class="h-24 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Previous</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Current</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Destination</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
							<tr v-if="Documents.data.length == 0" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<th class="h-24 px-3 py-2 text-left lg:h-full">End-User</th>
								<th class="h-24 px-3 py-2 text-left lg:h-full">Document</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Previous</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Current</th>
								<th class="h-16 px-3 py-2 text-left lg:h-full">Destination</th>
								<th class="h-12 px-3 py-2 text-left lg:h-full">Action </th>
							</tr>
						</thead>
						<tbody class="flex-1 sm:flex-none bg-white divide-y divide-purple-800 lg:divide-y lg:divide-gray-200">
							<tr v-if="!Documents.data.length">
								<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
									No Data Available
								</td>
							</tr>
							<tr v-show="Documents.data.length > 0" v-for="docs in Documents.data" :key="docs" class="flex flex-col flex-no-wrap sm:table-row mb-2 sm:mb-0">
								<td class="h-24 px-3 py-2 lg:h-full">
									<div class="flex items-center">
										<div class="flex-shrink-0 h-10 w-10">
											<img class="h-10 w-10 rounded-full" :src="'/storage/'+docs.users_details.user.profile_photo_path" alt="">
										</div>
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
												<span v-if="docs.users_details.gender == 'Male'">
													Mr.
												</span>	
												<span v-else>
													Ms.
												</span>	
												{{ docs.users_details.lname }}
											</div>
										</div>
									</div>
								</td>
								<td class="h-24 px-3 py-2 lg:h-full">
									<div class="text-xs text-gray-900">{{ docs.doc_type }} </div>
									<div class="text-xs text-gray-500">{{ docs.documents_particulars_tbl.length }} Particulars</div>
									<div class="text-xs text-purple-600">DTRAK No. {{ docs.dtrack_no }}</div>
									<span v-if="docs.doc_current_status == 'Accomplished PR - Processing for PO'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
										Accomplished PR
									</span>
									<span v-if="docs.doc_current_status == 'Accomplished PO'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
										Accomplished PO
									</span>		
								</td>

								<!-- if there are exactly 2 ka logs -->
								<td v-if="docs.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-red-500" v-if="docs.documents_status_log_tbl[1] != null" :Division="docs.documents_status_log_tbl[1].division" :Cluster="docs.documents_status_log_tbl[1].cluster" :Office="docs.documents_status_log_tbl[1].office" :Type="1"></doc-location>
								</td>
								<td v-if="docs.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-yellow-500" v-if="docs.documents_status_log_tbl[0] != null" :Division="docs.documents_status_log_tbl[0].division" :Cluster="docs.documents_status_log_tbl[0].cluster" :Office="docs.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="docs.documents_status_log_tbl.length > 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-destination class="text-pink-500" v-if="docs.documents_status_log_tbl[0] != null && docs.documents_status_log_tbl[0].forwarded_to != null" :Destination="docs.documents_status_log_tbl[0].forwarded_to"></doc-destination>
									<p v-if="docs.documents_status_log_tbl[0] != null && docs.documents_status_log_tbl[0].forwarded_to == null">
										<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
											Pending
										</span>
									</p>
								</td>

								<!-- if there are exactly 1 ka logs -->
								<td v-if="docs.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-red-500" v-if="docs.documents_status_log_tbl[0] != null" :Division="docs.documents_status_log_tbl[0].division" :Cluster="docs.documents_status_log_tbl[0].cluster" :Office="docs.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="docs.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-location class="text-yellow-500" v-if="docs.documents_status_log_tbl[0] != null" :Division="docs.documents_status_log_tbl[0].division" :Cluster="docs.documents_status_log_tbl[0].cluster" :Office="docs.documents_status_log_tbl[0].office" :Type="1"></doc-location>
								</td>
								<td v-if="docs.documents_status_log_tbl.length == 1" class="h-16 px-3 py-2 lg:h-full" style="font-size:.55rem;line-height:1rem;">
									<doc-destination class="text-pink-500" v-if="docs.documents_status_log_tbl[0] != null && docs.documents_status_log_tbl[0].forwarded_to != null" :Destination="docs.documents_status_log_tbl[0].forwarded_to"></doc-destination>
								</td>

								<td class="h-12 text-left px-3 py-2 lg:h-full text-sm font-medium">
									<div class="inline-flex gap-2">
										<a @click="ViewingModal = true, viewParticulars(docs)" class="text-purple-500 hover:text-purple-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
										<hr v-if="docs.final_status == 'Processing'" class="border-gray-500 my-2">
										<a v-if="docs.final_status == 'Processing'" @click="ForwardingModal = true, passDtrakNo(docs.dtrack_no), viewParticulars(docs)" class="text-green-500 hover:text-green-700 cursor-pointer">Forward <i class="fas fa-file-export"></i> </a>
									</div>
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

		<!-- Modal for Logging Document -->
		<modal :show="LogDocumentModal" maxWidth="md" >
			<div class="py-2">
				<form @submit.prevent="submitLogDocumentModal">
					<!-- header -->
					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="text-gray-500">
							<span class="text-2xl font-semibold">Log a document</span><br>
							<span class="text-xs font-light">(This is for receiving documents only)</span>
						</div>
					</section>

					<section class="w-full bg-white px-5 pb-3 mt-2 border-b border-gray-300" >
						<label class="block text-purple-500">
							DTRAK No. 
							<input required ref="logDtrackNo" v-model="LogForm.logDtrackNo" type="text"  v-on:keyup="checkDtrackNo($event)" class="mt-1 py-2 bg-gray-100 border-0 rounded-sm w-full text-purple-500" />
						</label>
					</section>

					<section v-if="this.ToggleErrorLogForm == false" class="w-full bg-white px-5 pb-3 mt-3 text-xs border-b border-gray-300" >
						<p class="text-xl text-red-500">Incorrect Dtrack Number</p>
						<p class="text-sm text-gray-500 italic">Please review the presented document and look for the DTRAK number.</p>
					</section>

					<section v-if="this.ToggleErrorLogForm == true" class="w-full bg-white px-5 pb-3 mt-3 border-b border-gray-300" >
						<div class="flex">
							<div class="w-1/2 px-2">
								<label class="block text-purple-800 text-xs">
									End-User/Origin
								</label>
								<span class="text-gray-500 text-base"> {{ LogDocData.users_details.fname }} &nbsp; {{ LogDocData.users_details.lname }} </span>

								<p class="my-1"></p>
								<label class="block text-purple-800 text-xs ">
									Document Type
								</label>
								<span class="text-gray-500 text-base">
									{{ this.LogDocData.doc_type }}
								</span>

								<p class="my-1"></p>
								<label class="block text-purple-800 text-xs ">
									Particulars
								</label>
								<span class="text-gray-500 text-base">
									{{ this.LogDocData.documents_particulars_tbl.length }}
								</span>
							</div>
							
							<div class="w-1/2 px-2 text-xs">
								<label class="block text-purple-800">
									Received from
								</label>
								<doc-destination class="text-gray-500" :Destination="this.LogDocData.doc_current_location"></doc-destination>	
							</div>
						</div>
					</section>

					<section class="px-3 pt-3 pb-1 flex justify-between items-center">
							<button v-if="this.ToggleErrorLogForm == true"  type="submit" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none">
								Received <i class="fas fa-file-import"></i>
							</button>
						<div class="inline-flex gap-3 ml-auto">
							<button type="button" @click="closeModal(2)" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-3 py-2 mx-0 outline-none">
							close <i class="fas fa-times-circle"></i>
							</button>
						</div>
					</section>
				</form>
			</div>
		</modal>

		<!-- Modal for Viewing Document -->
		<modal :show="ViewingModal" >
			<div class="py-2">
				<form>
					<!-- header -->
					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="text-gray-500">
							<span class="text-2xl font-semibold">{{ SpecificDocData.doc_type }}</span><br>
							<span class="text-xs font-light" >Origin: {{ this.OriginFname }}  {{ this.OriginLname }} </span><br>
						</div>
						<div class="block ml-auto">
							<div class="text-xs text-gray-500">Dtrack No. <span class="text-green-500">{{ SpecificDocData.dtrack_no }}</span> </div>
							<!-- <span class="text-xs text-gray-500 font-light" v-if="SpecificDocData.doc_type == 'Purchase Request' && SpecificDocData.documents_mutation_log_tbl != null">PR No. <span class="text-green-500">{{ SpecificDocData.documents_mutation_log_tbl[0].doc_from }}</span>	</span><br> -->
							<div class="text-xs text-gray-500 font-light ml-auto">Created On: {{ frontEndDateFormat(SpecificDocData.created_at) }}</div>	
						</div>
					</section>
					<section class="flex gap-x-4 px-5 mt-2  overflow-x-auto" v-if="ToggleDocsHistory_Particulars">
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

					<section class="px-5 mt-2 overflow-x-auto" v-if="!ToggleDocsHistory_Particulars">
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
										{{ frontEndDateFormat(history.created_at) }}
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
										<doc-destination v-if="history.forwarded_to" class="text-gray-500" :Destination="history.forwarded_to"></doc-destination>	
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
								<span v-if="ToggleDocsHistory_Particulars">Docs History <i class="fas fa-history"></i></span>
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

		<!-- Modal for Forwarding Document -->
		<modal :show="ForwardingModal" maxWidth="2xl" >
			<div class="py-2">
				<form @submit.prevent="submitForwardingModal">
					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="text-gray-500">
							<span class="text-2xl font-semibold">Route document |</span> <span class="text-lg"> {{ 'DTRAK No. ' + this.ForwardDocForm.DtrakNoHolder }} </span> <br>
							<span class="text-xs font-light">(This is for routing received documents only)</span>
						</div>
					</section>

					<div class="flex flex-wrap px-5 py-2">
						<div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
						<!-- -->
							<section  v-if="SpecificDocData.doc_type == 'Purchase Request' && SpecificDocData.doc_current_location == '3,0,54' && SpecificDocData.doc_current_status == 'For PR Numbering'" class="flex justify-between items-center">
								<div class="w-full block">
									<div class="block text-purple-500 my-2 text-base">
										Approved PR <br/>
										<span class="text-xs">Please add a PR Number for tracking</span>
									</div>
									<div class="block text-gray-500 mb-2">
										<label for="doctype" class="text-xs">PR No.</label>
										<input required v-model="ForwardDocForm.DocumentMutationFrom" type="text" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
									</div>

								</div>
							</section>

							<!-- For PO -->
							<section  v-if="SpecificDocData.doc_type == 'Purchase Request' && SpecificDocData.doc_current_location == '3,0,54' && SpecificDocData.doc_current_status == 'For Purchase Order (PO)'" class="flex justify-between items-center">
								<div class="w-full block">
									<div class="block text-purple-500 my-2 text-base">
										For PO <br/>
										<span class="text-xs">Please add a PO Number for tracking</span>
									</div>
									<div class="block text-gray-500 mb-2">
										<label for="doctype" class="text-xs">PO No.</label>
										<input required v-model="ForwardDocForm.DocumentMutationTo" type="text" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
									</div>

								</div>
							</section>

							<section class="flex justify-between items-center">
								<div class="w-full block">
									<div class="block text-purple-500 my-2 text-base">
										Destination
									</div>

									<div class="block text-gray-500">
										<label for="division" class="text-xs">Division</label>
										<select id="division" name="division" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocDivisionData" @change='getOfficesCluster(ForwardDocForm.ForwardDocClusterData,ForwardDocForm.ForwardDocDivisionData),getSpecificUser()' required>
											<option v-for='divData in Division_List' :key="divData" :value='divData.id'>{{ divData.name }}</option>
										</select>
									</div>

									<div class="block text-gray-500" v-if="ForwardDocForm.ForwardDocDivisionData == 2 || ForwardDocForm.ForwardDocDivisionData == 3">
										<label for="cluster" class="text-xs">Section/Cluster</label>
										<select id="cluster" name="cluster" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocClusterData" @change='getOffices(ForwardDocForm.ForwardDocClusterData,ForwardDocForm.ForwardDocDivisionData),getSpecificUser()'>
											<option v-for='clusData in Cluster_List' :key="clusData" :value='clusData.id'>{{ clusData.name }}</option>
										</select>
									</div>

									<div class="block text-gray-500">
										<label for="office" class="text-xs">Office</label>
										<select id="office" name="office" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocOfficeData" @change="getSpecificUser()" required>
											<option v-for='officeData in Office_List' :key="officeData" :value='officeData.id'>{{ officeData.name }}</option>
										</select>
									</div>

									<div class="block text-gray-500 mb-2">
										<label for="doctype" class="text-xs">Specific User</label>
										<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model='ForwardDocForm.SpecificUserData' required>
											<option v-for="option in SpecificUser" :key="option.id" :value="option.id">
												{{ option.fname +' '+ option.lname }}
											</option>
										</select>
									</div>

									<div class="block text-purple-500 my-3 text-base">
										Document Action
									</div>
									<div class="block text-gray-500 mb-2">
										<label for="doctype" class="text-xs">Action</label>
										<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model='ForwardDocForm.ForwardDocAction' required>
											<doc-actions></doc-actions>
										</select>
									</div>
								</div>
							</section>
						</div>

						<div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2 px-2">
							<div class="w-full block">
								<div class="block text-gray-500 my-3">
									<!-- Toggle A -->
									<label for="toogleA" class="flex items-center cursor-pointer">
										<!-- toggle -->
										<div class="relative">
											<!-- input -->
											<input id="toogleA" type="checkbox" class="sr-only" v-model="ForwardDocForm.AddNote"/>
											<!-- line -->
											<div class="w-10 h-4 bg-gray-100 rounded-full shadow-inner"></div>
											<!-- dot -->
											<div class="dot absolute w-6 h-6 border-1 bg-gray-500 rounded-full shadow-md -left-1 -top-1 transition"></div>
										</div>
										<!-- label -->
										<div class="ml-3 font-medium text-xs">
											<span v-if="ForwardDocForm.AddNote == true" class="text-green-500">Please fill-out note for notes/actions/remarks</span>
											<span v-if="ForwardDocForm.AddNote == false" class="text-red-500">Attach a note?</span>
										</div>
									</label>
								</div>

								<!-- Has Note -->
								<div class="block text-gray-500 my-2" v-if="ForwardDocForm.AddNote == true">
									<textarea id="about" type="text" v-model="ForwardDocForm.ForwardDocNote" name="note" rows="5" class="shadow-sm focus:ring-indigo-500 focus:ring-1 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Place your comments here..."></textarea>
								</div>

								<!-- Has Attachment -->
								<div class="block text-gray-500 my-3">
									<!-- Toggle A -->
									<label for="toogleB" class="flex items-center cursor-pointer">
										<!-- toggle -->
										<div class="relative">
											<!-- input -->
											<input id="toogleB" type="checkbox" class="sr-only" v-model="ForwardDocForm.AddAttachment"/>
											<!-- line -->
											<div class="w-10 h-4 bg-gray-100 rounded-full shadow-inner"></div>
											<!-- dot -->
											<div class="dot absolute w-6 h-6 border-1 bg-gray-500 rounded-full shadow-md -left-1 -top-1 transition"></div>
										</div>
										<!-- label -->
										<div class="ml-3 font-medium text-xs">
											<span v-if="ForwardDocForm.AddAttachment == true" class="text-green-500">Add files to attach</span>
											<span v-if="ForwardDocForm.AddAttachment == false" class="text-red-500">Attach a file?</span>
										</div>
									</label>
								</div>

								<div class="block text-gray-500 my-2" v-if="ForwardDocForm.AddAttachment == true">
									<UploadImages @change="handleImages" :max="5" maxError="Max files exceed" fileError="Please upload an image file. (.PNG, .JPEG, .JPG)" uploadMsg="Add files to attach"/>
								</div>
							</div>
						</div>
					</div>

					<section class="px-3 border-t border-gray-300  pt-3 pb-1 flex justify-between items-center">
						<div class="inline-flex gap-3 ml-auto">
							<button v-if="isForwardingDocFormComplete" type="submit" class="focus:outline-none bg-white text-xs text-green-500 hover:bg-green-500 uppercase hover:shadow-lg hover:text-white border border-green-500 rounded-full px-3 py-2 mx-0 outline-none">
								Received & Forward <i class="fas fa-file-import"></i>
							</button>
							<button type="button" @click="closeModal(3)" class="focus:outline-none bg-white text-xs text-red-500 hover:bg-red-500 uppercase hover:shadow-lg hover:text-white border border-red-500 rounded-full px-3 py-2 mx-0 outline-none">
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
		props: ['Documents','UsersDetails','IncomingDocuments'],
		data() {
			return {
				ViewingModal: false,
				LogDocumentModal: false,
				ForwardingModal: false,
				ForwardingModal: false,
				ToggleDocsHistory_Particulars: true,
				LogForm: this.$inertia.form({
					logDtrackNo: null,
				}),
				ForwardDocForm: this.$inertia.form({
					ForwardDocAction: false,
					AddNote: false,
					AddAttachment: false,
					ForwardDocNote: null,
					ForwardDocDivisionData: null,
					ForwardDocClusterData: 0,
					ForwardDocOfficeData: 0,
					ForwardDocAction: null,
					CreateDocfile: [],
					DtrakNoHolder: "",
					SpecificUserData: null,
					DocumentMutationFrom: null,
					DocumentMutationTo: null,
					DocumentMutationTypeFrom: null,
					DocumentMutationTypeTo: null,
				}),
				SearchDoc:'',
				IncomingDtrackArray: [],
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				LogDocData: null,
				ToggleErrorLogForm: null,
				Division_List: [],
				Office_List: [],
				Cluster_List: [],
				SpecificUser: [],
				Doc_Action_Options: [
					{ text:"For Abstract as Read", value: "For Abstract as Read" },
					{ text:"For Action", value: "For Action" },
					{ text:"For Action Taken", value: "For Action Taken" },
					{ text:"For Approval", value: "For Approval" },
					{ text:"For ARD's approval", value: "For ARD's approval" },
					{ text:"For awarding", value: "For awarding" },
					{ text:"For CAF", value: "For CAF" },
					{ text:"For Canvass", value: "For Canvass" },
					{ text:"For Certification", value: "For Certification" },
					{ text:"For Clearance", value: "For Clearance" },
					{ text:"For Comment", value: "For Comment" },
					{ text:"For Confirmation", value: "For Confirmation" },
					{ text:"For Coordination", value: "For Coordination" },
					{ text:"For Correction", value: "For Correction" },
					{ text:"For Delivery", value: "For Delivery" },
					{ text:"For Discussion / Meeting", value: "For Discussion / Meeting" },
					{ text:"For Dissemination", value: 'For Dissemination' },
					{ text:"For Distribution", value: "For Distribution" },
					{ text:"For Draft Message", value: "For Draft Message" },
					{ text:"For Draft Reply", value: "For Draft Reply" },
					{ text:"For Evaluation", value: "For Evaluation" },
					{ text:"For Filling", value: "For Filling" },
					{ text:"For Filling Up Forms", value: "For Filling Up Forms" },
					{ text:"For Finalization", value: "For Finalization" },
					{ text:"For Information", value: "For Information" },
					{ text:"For Initial", value: "For Initial" },
					{ text:"For Inspection", value: "For Inspection" },
					{ text:"For Internet Posting", value: "For Internet Posting" },
					{ text:"For Intranet Posting", value: "For Intranet Posting" },
					{ text:"For Legal Action", value: "For Legal Action" },
					{ text:"For Mailing", value: "For Mailing" },
					{ text:"For Monitoring", value: "For Monitoring" },
					{ text:"For Mode of Procurement", value: "For Mode of Procurement" },
					{ text:"For Newspaper Publication", value: "For Newspaper Publication" },
					{ text:"For Payment", value: "For Payment" },
					{ text:"For PO preparation", value: "For PO preparation" },
					{ text:"For PR Numbering", value: "For PR Numbering" },
					{ text:"For Processing", value: "For Processing" },
					{ text:"For Processing - CA", value: "For Processing - CA" },
					{ text:"For Processing - LTO", value: "For Processing - LTO" },
					{ text:"For Purchase Order (PO)", value: "For Purchase Order (PO)" },
					{ text:"For RD's approval", value: "For RD's approval" },
					{ text:"For Re-canvass", value: "For Re-canvass" },
					{ text:"For Re-Evaluation", value: "For Re-Evaluation" },
					{ text:"For Recommendation", value: "For Recommendation" },
					{ text:"For RFQ", value: "For RFQ" },
					{ text:"For Registry", value: "For Registry" },
					{ text:"For Release", value: "For Release" },
					{ text:"For Resolution", value: "For Resolution" },
					{ text:"For Review", value: "For Review" },
					{ text:"For Revision", value: "For Revision" },
					{ text:"For Shopping", value: "For Shopping" },
					{ text:"For Signature", value: "For Signature" },
					{ text:"For Stock Availability Inquiry", value: "For Stock Availability Inquiry" },
					{ text:"For Submission", value: "For Submission" },
					{ text:"PR w/ canvass for opening", value: "PR w/ canvass for opening" },
					{ text:"Receiving for approval", value: "Receiving for approval" },
					{ text:"Receiving for Processing", value: "Receiving for Processing" },
					{ text:"Receiving for signature", value: "Receiving for signature" },
				],
			};
		},
		computed: {
			isForwardingDocFormComplete () {
				if(this.ForwardDocForm.ForwardDocDivisionData && this.ForwardDocForm.ForwardDocAction){
					return this.ForwardDocForm.ForwardDocDivisionData && this.ForwardDocForm.ForwardDocAction;
				}else{
					return false;
				}
			}
		},
		methods: {
			closeModal(type){
				Mylib.closeModal(this,type);
			},
			viewParticulars(data){
				Mylib.viewParticulars(this,data);
			},
			passDtrakNo(data){
				console.log("passDtrakNo");
				this.ForwardDocForm.DtrakNoHolder = data;
				console.log(this.ForwardDocForm.DtrakNoHolder);
			},
			openImageInNewTab(event){
				Mylib.openImageInNewTab(event);
			},
			formatAmount(value) {
				let val = (value/1).toFixed(2).replace(',', '.')
				return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
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
				console.log(this.ForwardDocForm.ForwardDocDivisionData+' '+this.ForwardDocForm.ForwardDocOfficeData+' '+this.ForwardDocForm.ForwardDocClusterData);
                axios.get('/getSpecificUser',{
                 params: {
                   division_id: this.ForwardDocForm.ForwardDocDivisionData,
                   cluster_id: this.ForwardDocForm.ForwardDocClusterData,
                   office_id: this.ForwardDocForm.ForwardDocOfficeData,
                 }
              }).then(function(response){
                    this.SpecificUser = response.data;
					console.log(response.data);
                }.bind(this));
            },
			checkDtrackNo(event){
				if(event.keyCode == 13) {
					event.preventDefault();
					return false;
				}else{
					for(var i=0; i<this.IncomingDocuments.length; i++) {
						if(this.IncomingDocuments[i].dtrack_no.toString() == this.LogForm.logDtrackNo.toString()) {
							console.log("MATCHED");
							this.ToggleErrorLogForm = true;
							this.LogDocData = this.IncomingDocuments[i];
							console.log(this.IncomingDocuments[i]);
							break;
						}else{
							this.ToggleErrorLogForm = false;
							this.LogDocData = [];
							// console.log("UNMATCHED");
						}
					}
				}
			},
			submitLogDocumentModal(){
				this.$inertia.post(route('office.logdoc'), this.LogForm, {
 					onSuccess: (res) => this.LogDocumentModal = false,
					onFinish: () => this.LogForm.reset(),
				}).then(function (response) {
					console.log(response);
            	}.bind(this));
			},
			submitForwardingModal(){
				// console.log(this.ForwardDocForm);
				this.$inertia.post(route('office.routedoc'), this.ForwardDocForm, {
					forceFormData: true,
 					onSuccess: (res) => this.ForwardingModal = false,
					onFinish: () => this.ForwardDocForm.reset(),
				}).then(function (response) {
					this.$inertia.reload();
            	}.bind(this));
			},
			handleImages(files){
				for(var i=0;i<files.length;i++){
					this.ForwardDocForm.CreateDocfile.push(files[i]);
				}
				console.log(this.ForwardDocForm.CreateDocfile);
				if(files.length > this.ForwardDocForm.CreateDocfile.length || files.length < this.ForwardDocForm.CreateDocfile.length){
					this.ForwardDocForm.CreateDocfile = [];
					for(var i=0;i<files.length;i++){
						this.ForwardDocForm.CreateDocfile.push(files[i]);
					}
					console.log(this.ForwardDocForm.CreateDocfile);
				}
			},
			frontEndDateFormat(date_data) {
				return Mylib.frontEndDateFormat(date_data);
        	},
			forIndex(index) {
				return index+1
			},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
			// Searching
			searchDocuments: function() {
				console.log("searchDocuments");
					this.$inertia.get(route('office.searchDocuments'), { SearchDoc: this.SearchDoc, RedirectComponent: 'Documents/Incoming' }, { replace: true })
			},
			// Reset Searching
			resetSearchDocuments: function() {
				this.$inertia.get(route('office.logged'), { }, { })
            },
		},
		created: function(){
			this.getOfficesDivision();
        }
    };
</script>
<template>
	<office-layout>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<div class="lg:flex lg:items-center lg:justify-between mb-5">
					<div class="flex-1 min-w-0">
						<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
							My Documents
						</h2>
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6"></div>
					</div>
					<div class="mt-5 flex lg:mt-0 lg:ml-4">
						<span class="sm:ml-3">
							<button @click="CreateDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-white text-green-600 hover:bg-green-700 hover:text-white focus:outline-none border-green-700">
								<i class="fas fa-file-signature"></i> &nbsp;	
								Create Docs
							</button>
						</span>
					</div>
				</div>

				<div class="flex flex-col">
					<div class="-my-2 mx-10 overflow-x-auto sm:-mx-6 lg:-mx-8">
						<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
							<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
								<table class="table-auto min-w-full divide-y divide-gray-200">
									<thead class="text-xs bg-gray-50">
										<tr>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												End-User
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Document
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Previous
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Current
											</th>
											<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
												Destination
											</th>
											<th scope="col" class="relative px-6 py-3">
												<span class="sr-only">View</span>
											</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										<tr v-if="!incomingDocuments.data.length">
											<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
												No Data Available
											</td>
										</tr>
										<tr v-show="incomingDocuments.data.length > 0" v-for="(item, index) in incomingDocuments.data" :key="index" class="border-r-8 border-green-500">
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="flex items-center">
													<div class="flex-shrink-0 h-10 w-10">
														<img class="h-10 w-10 rounded-full" :src="'/storage/'+$page.props.user.profile_photo_path" alt="">
													</div>
													<div class="ml-4">
														<div class="text-sm font-medium text-gray-900">
															<span v-if="item.users_details.gender == 'Male'">
																Mr.
															</span>	
															<span v-else>
																Ms.
															</span>
															{{ item.users_details.fname }} {{ item.users_details.lname }}
														</div>
													</div>
												</div>
											</td>
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="text-xs text-gray-900">{{ item.doc_type }} </div>
												<div class="text-xs text-gray-500">{{ item.documents_particulars_tbl.length }} Particulars</div>
												<div class="text-xs text-red-500">DTRAK No. {{ item.dtrack_no }}</div>
											</td>
											
											<!-- if there are exactly 2 ka logs -->
											<td v-if="item.documents_status_log_tbl.length > 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-red-500" v-if="item.documents_status_log_tbl[1] != null" v-html=" retDiv(item.documents_status_log_tbl[1].division,item.documents_status_log_tbl[1].section,item.documents_status_log_tbl[1].cluster,1)"></p>
											</td>
											<td v-if="item.documents_status_log_tbl.length > 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-yellow-500"  v-if="item.documents_status_log_tbl[0] != null" v-html=" retDiv(item.documents_status_log_tbl[0].division,item.documents_status_log_tbl[0].section,item.documents_status_log_tbl[0].cluster,1)"></p>
											</td>
											<td v-if="item.documents_status_log_tbl.length > 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-pink-500" v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to != null"  v-html="retDiv(item.documents_status_log_tbl[0].forwarded_to,'','',2)"></p>
												<p v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to == null">
													<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
														Pending
													</span>
												</p>
											</td>

											<!-- if there are exactly 1 ka logs -->
											<td v-if="item.documents_status_log_tbl.length == 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-red-500" v-if="item.documents_status_log_tbl[0] != null" v-html=" retDiv(item.documents_status_log_tbl[0].division,item.documents_status_log_tbl[0].section,item.documents_status_log_tbl[0].cluster,1)"></p>
											</td>
											<td v-if="item.documents_status_log_tbl.length == 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-yellow-500" v-if="item.documents_status_log_tbl[0] != null" v-html=" retDiv(item.documents_status_log_tbl[0].division,item.documents_status_log_tbl[0].section,item.documents_status_log_tbl[0].cluster,1)"></p>
											</td>
											<td v-if="item.documents_status_log_tbl.length == 1" class="px-6 py-4 whitespace-nowrap" style="font-size:.55rem;line-height:1rem;">
												<p class="text-pink-500" v-if="item.documents_status_log_tbl[0] != null && item.documents_status_log_tbl[0].forwarded_to != null"  v-html="retDiv(item.documents_status_log_tbl[0].forwarded_to,'','',2)"></p>
											</td>

											<td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
												<a @click="ViewingModal = true, viewParticulars(item), toggleParticularsDocHistory()" class="text-green-500 hover:text-green-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
											</td>
										</tr>
										<!-- More items... -->
									</tbody>
								</table>
							</div>
						</div>
					</div>
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

					<button @click="closeModal(2)" class="rounded-md text-gray-300 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-red">
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
							<input required ref="dtrak" type="text" v-model="CreateDocForm.CreateDtrackNo" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" />
						</div>

						<div class="block text-purple-500 mb-2">
							<label for="doctype" class="text-base">Document Type</label>
							<select name="doctype" class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" id="doctype" v-model="CreateDocForm.CreateDocType" required>
								<option v-for="option in DocTypeOptions" :key="option.value" :value="option.value">
									{{ option.text }}
								</option>
							</select>
						</div>

						<div class="block text-purple-500 my-2 text-base">
							Destination
						</div>

						<div class="flex gap-2">
							<div class="block text-gray-500 mb-2 w-1/2">
								<label for="doctype" class="text-xs">Division</label>
								<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocDivisionData" @change='getSection()' required>
								<option v-for='divData in Division_List' :key="divData.value" :value='divData.id'>{{ divData.name }}</option>
								</select>
							</div>
							
							<div class="block text-gray-500 mb-2 w-1/2">
								<label for="doctype" class="text-xs">Section</label>
								<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocSectionData" @change='getCluster()'>
								<option v-for='secData in Section_List' :key="secData.value" :value='secData.id'>{{ secData.name }}</option>
								</select>
							</div>
						</div>
						<div v-if="Cluster_List.length > 0 && CreateDocForm.CreateDocDivisionData == 4" class="block text-gray-500 mb-2">
							<label for="doctype" class="text-xs">Cluster</label>
							<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="CreateDocForm.CreateDocClusterData">
							<option v-for='clusData in Cluster_List' :key="clusData.value" :value='clusData.id'>{{ clusData.name }}</option>
							</select>
						</div>

						<div class="block text-gray-500 mb-2">
							<label for="doctype" class="text-xs">Action</label>
							<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model='CreateDocForm.CreateDocAction' required>
								<option v-for="option in Doc_Action_Options" :key="option.value" :value="option.value">
									{{ option.text }}
								</option>
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
							<span class="text-2xl font-semibold">{{ SpecificDocData.doc_type }}</span><br>
							<span class="text-xs font-light" >Origin: {{ this.OriginFname }}  {{ this.OriginLname }} </span><br>
						</div>
						<div class="block ml-auto">
							<div class="text-xs text-gray-500">Dtrack No. <span class="text-green-500">{{ SpecificDocData.dtrack_no }}</span> </div>
							<div class="text-xs text-gray-500 font-light ml-auto">Created On: {{ frontEndDateFormat(SpecificDocData.created_at) }}</div>	
						</div>
					</section>
					<section class="flex gap-x-4 px-5 mt-2" v-if="!ToggleDocsHistory_Particulars">
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

					<section class="px-5 mt-2" v-if="ToggleDocsHistory_Particulars">
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
										Remarks/Notes
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Status
									</th>
									<th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Attachments
									</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								<tr v-for="history in SpecificDocData.documents_status_log_tbl" :key="history" class="border-r-8 border-green-500 text-gray-500" style="font-size:.65rem;line-height:1rem;">
									<td class="px-2 py-2 whitespace-nowrap">
										{{ frontEndDateFormat(history.created_at) }}
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-html=" retDiv(history.division,history.section,history.cluster,1)"></span>	
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										{{ history.doc_notes }}
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
											{{ history.document_status }}
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

    export default {
        components: {
            OfficeLayout,
            Modal,
			UploadImages,
        },
		props: ['incomingDocuments','UsersDetails'],
		data() {
			return {
				ViewingModal: false,
				CreateDocumentModal: false,
				ToggleDocsHistory_Particulars: false,
				CreateDocForm: this.$inertia.form({
					CreateDtrackNo: null,
					CreateDocType: null,
					CreateDocDivisionData: null,
					CreateDocSectionData: 0,
					CreateDocClusterData: 0,
					CreateDocAction: false,
					AddNote: false,
					AddAttachment: false,
					CreateDocNote: null,
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
				preview: null,
				image: null,
				preview_list: [],
				image_list: [],
				DocTypeOptions: [
					{ text:'Accomplishment Report', value: 'Accomplishment Report' },
					{ text:'Accomplishment Receipt Equipment', value: 'Accomplishment Receipt Equipment' },
					{ text:'Acknowledgement Receipt', value: 'Acknowledgement Receipt' },
					{ text:'Activity Design', value: 'Activity Design' },
					{ text:'Administrative Order', value: 'Administrative Order' },
					{ text:'Advertising Invoice', value: 'Advertising Invoice' },
					{ text:'Advertising Quotation', value: 'Advertising Quotation' },
					{ text:'Advisory', value: 'Advisory' },
					{ text:'Affidavit of Non-Disclosure', value: 'Affidavit of Non-Disclosure' },
					{ text:'Agency Procurement Request', value: 'Agency Procurement Request' },
					{ text:'Annual Procurement Plan', value: 'Annual Procurement Plan' },
					{ text:'Application', value: 'Application' },
					{ text:'Application for Permit to Construct - Birthing Home', value: 'Application for Permit to Construct - Birthing Home' },
					{ text:'Application for Accreditation - Drug Abuse Treatment & Rehab Center', value: 'Application for Accreditation - Drug Abuse Treatment & Rehab Center' },
					{ text:'Application for Accreditation - Drug Testing Laboratory', value: 'Application for Accreditation - Drug Testing Laboratory' },
					{ text:'Application for Accreditation - Medical Facility for OW & Seafarers', value: 'Application for Accreditation - Medical Facility for OW & Seafarers' },
					{ text:'Application for Accreditation - Stem Cell', value: 'Application for Accreditation - Stem Cell' },
					{ text:'Application for Clearance to Operate - HMO', value: 'Application for Clearance to Operate - HMO' },
					{ text:'Application for LTO - Ambulatory Surgical Clinic', value: 'Application for LTO - Ambulatory Surgical Clinic' },
					{ text:'Application for LTO - Birthing Homes', value: 'Application for LTO - Birthing Homes' },
					{ text:'Application for LTO - Dialysis Clinic', value: 'Application for LTO - Dialysis Clinic' },
					{ text:'Application for LTO - Hospital', value: 'Application for LTO - Hospital' },
					{ text:'Application for LTO - Infirmary', value: 'Application for LTO - Infirmary' },
					{ text:'Application for LTO - Kidney Transplant', value: 'Application for LTO - Kidney Transplant' },
					{ text:'Application for Permit to Construct - Blood Testing', value: 'Application for Permit to Construct - Blood Testing' },
					{ text:'Application for Permit to Construct - Dialysis Clinic', value: 'Application for Permit to Construct - Dialysis Clinic' },
					{ text:'Application for Permit to Construct - Drug Testing Laboratory', value: 'Application for Permit to Construct - Drug Testing Laboratory' },
					{ text:'Application for Permit to Construct - Hospital', value: 'Application for Permit to Construct - Hospital' },
					{ text:'Application for Permit to Construct - Infirmary', value: 'Application for Permit to Construct - Infirmary' },
					{ text:'Application for Permit to Construct - Medical Faciltiy for OW & Seafarers', value: 'Application for Permit to Construct - Medical Faciltiy for OW & Seafarers' },
					{ text:'Application for Permti to Construct - Ambulatory Surgical Clinic', value: 'Application for Permti to Construct - Ambulatory Surgical Clinic' },
					{ text:'Appln. for LTO/Accreditation', value: 'Appln. for LTO/Accreditation' },
					{ text:'Appointment Paper', value: 'Appointment Paper' },
					{ text:'Assets/Liabilities', value: 'Assets/Liabilities' },
					{ text:'Authority to Operate Blood Testing', value: 'Authority to Operate Blood Testing' },
					{ text:'Bidding Documents', value: 'Bidding Documents' },
					{ text:'Budget Utilization Request', value: 'Budget Utilization Request' },
					{ text:'C.T.O. Application', value: 'C.T.O. Application' },
					{ text:'CAF', value: 'CAF' },
					{ text:'Canvass', value: 'Canvass' },
					{ text:'Cert of No Pending Admini Case', value: 'Cert of No Pending Admini Case' },
					{ text:'Certificate - SSRS', value: 'Certificate - SSRS' },
					{ text:'Certificate of Employment', value: 'Certificate of Employment' },
					{ text:'Certificate of Registration', value: 'Certificate of Registration' },
					{ text:'Certificate of Undertaking', value: 'Certificate of Undertaking' },
					{ text:'Certificate Project Acceptance', value: 'Certificate Project Acceptance' },
					{ text:'Certificate System Acceptance', value: 'Certificate System Acceptance' },
					{ text:'Certificate Training/Diploma', value: 'Certificate Training/Diploma' },
					{ text:'Certificates', value: 'Certificates' },
					{ text:'Certification - TWG Honorarium', value: 'Certification - TWG Honorarium' },
					{ text:'Certification for Reimbursement', value: 'Certification for Reimbursement' },
					{ text:'Charge Account Order Slip', value: 'Charge Account Order Slip' },
					{ text:'CHT Reports', value: 'CHT' },
					{ text:'Clearance', value: 'Clearance' },
					{ text:'Clearance - PNDF Exemption', value: 'Clearance - PNDF Exemption' },
					{ text:'Clearance Certificate', value: 'Clearance Certificate' },
					{ text:'Clearing House of Purchase Req', value: 'Clearing House of Purchase Req' },
					{ text:'COBAC Resolution', value: 'COBAC Resolution' },
					{ text:'Complaints', value: 'Complaints' },
					{ text:'Compliance', value: 'Compliance' },
					{ text:'Compliance Requirements', value: 'Compliance Requirements' },
					{ text:'Confirmatory Result', value: 'Confirmatory Result' },
					{ text:'Contract', value: 'Contract' },
					{ text:'Contract - Advertisement', value: 'Contract - Advertisement' },
					{ text:'Contract of Service', value: 'Contract of Service' },
					{ text:'Credit Slip Form', value: 'Credit Slip Form' },
					{ text:'Daily Monitoring & Endorsement', value: 'Daily Monitoring & Endorsement' },
					{ text:'Delivery Receipt', value: 'Delivery Receipt' },
					{ text:'Department Circular', value: 'Department Circular' },
					{ text:'Department Memorandum', value: 'Department Memorandum' },
					{ text:'Department Order', value: 'Department Order' },
					{ text:'Department Personnel Order', value: 'Department Personnel Order' },
					{ text:'Disbursement Voucher', value: 'Disbursement Voucher' },
					{ text:'DTR', value: 'DTR' },
					{ text:'EDPMS Report', value: 'EDPMS Report' },
					{ text:'Endorsement', value: 'Endorsement' },
					{ text:'Executive Order', value: 'Executive Order' },
					{ text:'Flash Report', value: 'Flash Report' },
					{ text:'Fuel Request Form', value: 'Fuel Request Form' },
					{ text:'Fund Transfer', value: 'Fund Transfer' },
					{ text:'FYI (For your information)', value: 'FYI (For your information)' },
					{ text:'Gate / Building Pass', value: 'Gate / Building Pass' },
					{ text:'HEARS', value: 'HEARS' },
					{ text:'HEARS Update', value: 'HEARS Update' },
					{ text:'Incidental Report', value: 'Incidental Report' },
					{ text:'Inspection & Acceptance Report', value: 'Inspection & Acceptance Report' },
					{ text:'Inspection Report', value: 'Inspection Report' },
					{ text:'Inventory & Inspection Report', value: 'Inventory & Inspection Report' },
					{ text:'Inventory Checklist', value: 'Inventory Checklist' },
					{ text:'Inventory Report', value: 'Inventory Report' },
					{ text:'Invitation', value: 'Invitation' },
					{ text:'Invoice Receipt - Equipment', value: 'Invoice Receipt - Equipment' },
					{ text:'Invoice Receipt of Property', value: 'Invoice Receipt of Property' },
					{ text:'IPCR', value: 'IPCR' },
					{ text:'Job Hiring (Announcement)', value: 'Job Hiring (Announcement)' },
					{ text:'Job Order', value: 'Job Order' },
					{ text:'Leave Application', value: 'Leave Application' },
					{ text:'Legal Decision', value: 'Legal Decision' },
					{ text:'Legislative Advisory', value: 'Legislative Advisory' },
					{ text:'Letter', value: 'Letter' },
					{ text:'Letter - Complaint', value: 'Letter - Complaint' },
					{ text:'Letter - Endorsement', value: 'Letter - Endorsement' },
					{ text:'Letter - For Information', value: 'Letter - For Information' },
					{ text:'Letter - Inquiry', value: 'Letter - Inquiry' },
					{ text:'Letter - Invitation', value: 'Letter - Invitation' },
					{ text:'Letter - Referral', value: 'Letter - Referral' },
					{ text:'Letter - Request', value: 'Letter - Request' },
					{ text:'Letter for Inclusion', value: 'Letter for Inclusion' },
					{ text:'License to Operate', value: 'License to Operate' },
					{ text:'Liquidation Report', value: 'Liquidation Report' },
					{ text:'Logistic Request Form', value: 'Logistic Request Form' },
					{ text:'Mail', value: 'Mail' },
					{ text:'Mailing Envelope for Mail', value: 'Mailing Envelope for Mail' },
					{ text:'Manual', value: 'Manual' },
					{ text:'Meal Provision Request Form', value: 'Meal Provision Request Form' },
					{ text:'Memo of Understanding (MOU)', value: 'Memo of Understanding (MOU)' },
					{ text:'Memorandum', value: 'Memorandum' },
					{ text:'Memorandum Circular', value: 'Memorandum Circular' },
					{ text:'Memorandum of Agreement (MOA)', value: 'Memorandum of Agreement (MOA)' },
					{ text:'Memorandum of Understanding', value: 'Memorandum of Understanding' },
					{ text:'Memorandum Receipt', value: 'Memorandum Receipt' },
					{ text:'Monthly Report of Attendance', value: 'Monthly Report of Attendance' },
					{ text:'Monthly Statistical Report', value: 'Monthly Statistical Report' },
					{ text:'MSW Annual Narrative Report', value: 'MSW Annual Narrative Report' },
					{ text:'MSW Annual Psychosocial Report', value: 'MSW Annual Psychosocial Report' },
					{ text:'MSW Annual Statistical Report', value: 'MSW Annual Statistical Report' },
					{ text:'News Clippings', value: 'News Clippings' },
					{ text:'Notice of Award', value: 'Notice of Award' },
					{ text:'Notice of Meeting', value: 'Notice of Meeting' },
					{ text:'Obligation Request', value: 'Obligation Request' },
					{ text:'Office Memorandum', value: 'Office Memorandum' },
					{ text:'Office Order', value: 'Office Order' },
					{ text:'OPCR', value: 'OPCR' },
					{ text:'Other Documents', value: 'Other Documents' },
					{ text:'Payroll', value: 'Payroll' },
					{ text:'Permit to construct', value: 'Permit to construct' },
					{ text:'PES', value: 'PES' },
					{ text:'Petty Cash Voucher', value: 'Petty Cash Voucher' },
					{ text:'PLDT', value: 'PLDT' },
					{ text:'PO PROCESSING', value: 'PO PROCESSING' },
					{ text:'Position Paper', value: 'Position Paper' },
					{ text:'Post Mission Report', value: 'Post Mission Report' },
					{ text:'Post Travel Report', value: 'Post Travel Report' },
					{ text:'PPMP', value: 'PPMP' },
					{ text:'PR with CANVASS', value: 'PR with CANVASS' },
					{ text:'Pre-Repair Inspection', value: 'Pre-Repair Inspection' },
					{ text:'Pre/Post Repair Inspection Rep', value: 'Pre/Post Repair Inspection Rep' },
					{ text:'Price Report', value: 'Price Report' },
					{ text:'Proposal', value: 'Proposal' },
					{ text:'Provision Request Form', value: 'Provision Request Form' },
					{ text:'Purchase Order', value: 'Purchase Order' },
					{ text:'Purchase Request', value: 'Purchase Request' },
					{ text:'Radio Base Checklist', value: 'Radio Base Checklist' },
					{ text:'Regional Personnel Order', value: 'Regional Personnel Order' },
					{ text:'Reimbursement', value: 'Reimbursement' },
					{ text:'Remote Collection Permit', value: 'Remote Collection Permit' },
					{ text:'Renewal/Initial', value: 'Renewal/Initial' },
					{ text:'Replenishment', value: 'Replenishment' },
					{ text:'Replenishment of Mailing', value: 'Replenishment of Mailing' },
					{ text:'Reports', value: 'Reports' },
					{ text:'Request and Issue Slip', value: 'Request and Issue Slip' },
					{ text:'Request Financial Assistance', value: 'Request Financial Assistance' },
					{ text:'Request for Action', value: 'Request for Action' },
					{ text:'Request for Action Slip - QMS', value: 'Request for Action Slip - QMS' },
					{ text:'Request for Quotation', value: 'Request for Quotation' },
					{ text:'Request for Tagging', value: 'Request for Tagging' },
					{ text:'Resolutions', value: 'Resolutions' },
					{ text:'Sales Invoice', value: 'Sales Invoice' },
					{ text:'Service Level Agreement', value: 'Service Level Agreement' },
					{ text:'Service Order', value: 'Service Order' },
					{ text:'Service Record', value: 'Service Record' },
					{ text:'Service Request', value: 'Service Request' },
					{ text:'Statement of Account', value: 'Statement of Account' },
					{ text:'Supplemental APP', value: 'Supplemental APP' },
					{ text:'Supplies Availability Inquiry', value: 'Supplies Availability Inquiry' },
					{ text:'TACT Clearance', value: 'TACT Clearance' },
					{ text:'TACT FORM', value: 'TACT FORM' },
					{ text:'Terms of Reference', value: 'Terms of Reference' },
					{ text:'Travel Authority', value: 'Travel Authority' },
					{ text:'Travel Liquidation', value: 'Travel Liquidation' },
					{ text:'Travel Reimbursement', value: 'Travel Reimbursement' },
					{ text:'Utilization Report', value: 'Utilization Report' },
					{ text:'Vehicle Request', value: 'Vehicle Request' },
					{ text:'Vehicle Request Form', value: 'Vehicle Request Form' },
					{ text:'VOUCHERS', value: 'VOUCHERS' },
					{ text:'Waste Material Report', value: 'Waste Material Report' },
					{ text:'WFP', value: 'WFP' },
				],
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				Division_List: [],
				Section_List: [],
				Cluster_List: [],
				Doc_Action_Options: [
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
					{ text:"For Dissemination", value: 'Accom"For Dissemination"shment' },
					{ text:"For Distribution", value: "For Distribution" },
					{ text:"For Draft Message", value: "For Draft Message" },
					{ text:"For Draft Reply", value: "For Draft Reply" },
					{ text:"For Evaluation", value: "For Evaluation" },
					{ text:"For Filing", value: "For Filing" },
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
					{ text:"For Newspaper Publication", value: "For Newspaper Publication" },
					{ text:"For Payment", value: "For Payment" },
					{ text:"for PO preparation", value: "for PO preparation" },
					{ text:"For Processing", value: "For Processing" },
					{ text:"For Processing - CA", value: "For Processing - CA" },
					{ text:"For Processing - LTO", value: "For Processing - LTO" },
					{ text:"For Purchase Order (PO)", value: "For Purchase Order (PO)" },
					{ text:"For RD's approval", value: "For RD's approval" },
					{ text:"For Re-canvass", value: "For Re-canvass" },
					{ text:"For Re-Evaluation", value: "For Re-Evaluation" },
					{ text:"For Recommendation", value: "For Recommendation" },
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
				// ViewingModal
				if(type == 1){
					this.ViewingModal = false;
					// this.resetModal();
					this.SpecificDocData = [];
					console.log(this.SpecificDocData);
				}else if(type == 2){
					this.CreateDocumentModal = false;
				}else;
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
				var largeImage = document.getElementById(event.currentTarget.id);
				var url=largeImage.getAttribute('src');
				window.open(url,'_blank','docHistory');
			},
			viewParticulars(data){
				console.log("viewParticulars");
				console.log(data);
				this.SpecificDocData = data;
				this.OriginFname = this.SpecificDocData.users_details.fname;
				this.OriginLname = this.SpecificDocData.users_details.lname;
			},
			retDiv(div,sec,clus,type){
				var type2 = [];
				var divs = [
					"",
					"RD's OFFICE",
					"ARD's OFFICE",
					"LHSD",
					"MSD",
					"RLED",
				]
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

				if(type == 2){
				// if type 2 -> receives div then undefined 2 + 1 params,
					var answ = div.split(',');
					answ.forEach(function(obj){
						type2.push(parseInt(obj));
					});
				
					return divs[type2[0]] +'<br/>'+ secs[type2[1]] +"<br/>"+ cluster[type2[2]];

				}else{
					return divs[div] +'<br/>'+ secs[sec] +"<br/>"+ cluster[clus];
				}
				
			},
			formatAmount(value) {
				let val = (value/1).toFixed(2).replace(',', '.')
				return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			},
			frontEndDateFormat: function(date) {
				return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        	},
			// Methods for Dependent Dropdown
            getDivision: function(){
              axios.get('/getDivision')
              .then(function (response) {
                 this.Division_List = response.data;
				 console.log(this.Division_List);
              }.bind(this));
            },
			getSection: function() {
                axios.get('/getSection',{
                 params: {
                   division_id: this.CreateDocForm.CreateDocDivisionData
                 }
              }).then(function(response){
                    this.Section_List = response.data;
                }.bind(this));
            },
			getCluster: function() {
				console.log("getCluster");
                axios.get('/getCluster',{
                 params: {
                   section_id: this.CreateDocForm.CreateDocSectionData
                 }
              }).then(function(response){
                    this.Cluster_List = response.data;
                }.bind(this));
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
		},
		created: function(){
            this.getDivision()
        }
    };
</script>
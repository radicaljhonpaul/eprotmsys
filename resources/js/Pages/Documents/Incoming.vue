<template>
	<office-layout>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<div class="lg:flex lg:items-center lg:justify-between mb-5">
					<div class="flex-1 min-w-0">
						<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
							Logged Documents
						</h2>
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6"></div>
					</div>
					<div class="mt-5 flex lg:mt-0 lg:ml-4">
						<span class="sm:ml-3">
							<button v-if="incomingDocuments.length > 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-white text-green-600 hover:bg-green-700 hover:text-white focus:outline-none border-green-700">
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ incomingDocuments.length }}</div>
							</button>
 
							<button v-if="incomingDocuments.length == 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-gray-500 text-white focus:outline-none border-gray-700" disabled>
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ incomingDocuments.length }}</div>
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
											Received
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Forwarded
										</th>
										<th scope="col" class="relative px-6 py-3">
											<span class="sr-only">View</span>
										</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										<tr v-if="!LoggedDocuments.data.length">
											<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
												No Data Available
											</td>
										</tr>
										<tr v-show="LoggedDocuments.data.length > 0" v-for="docs in LoggedDocuments.data" :key="docs.created_at" class="border-r-8 border-green-500">
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="flex items-center">
													<div class="flex-shrink-0 h-10 w-10">
														<img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
													</div>
													<div class="ml-4">
														<div class="text-sm font-medium text-gray-900">
															<span v-if="docs.users_details.gender == 'Male'">
																Mr.
															</span>	
															<span v-else>
																Ms.
															</span>	
															{{ docs.users_details.fname }} {{ docs.users_details.lname }}
														</div>
													</div>
												</div>
											</td>
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="text-xs text-gray-900">{{ docs.doc_type }} </div>
												<div class="text-xs text-gray-500">{{ docs.documents_particulars_tbl.length }} Particulars</div>
												<div class="text-xs text-red-500">DTRAK No. {{ docs.dtrack_no }}</div>
												<p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.created_at) }} </p>
											</td>
											
											<!-- if there are exactly 2 ka logs -->
											<td v-if="docs.documents_status_log_tbl.length > 1" class="px-6 py-4 whitespace-nowrap text-red-500" style="font-size:.55rem;line-height:1rem;">
												<p v-if="docs.documents_status_log_tbl[1] != null" v-html=" retDivSecClus(docs.documents_status_log_tbl[1].division,docs.documents_status_log_tbl[1].section,docs.documents_status_log_tbl[1].cluster,1)"></p>
												<p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.documents_status_log_tbl[1].created_at) }} </p>
											</td>
											<td v-if="docs.documents_status_log_tbl.length > 1" class="px-6 py-4 whitespace-nowrap text-yellow-500" style="font-size:.55rem;line-height:1rem;">
												<p v-if="docs.documents_status_log_tbl[0] != null && docs.documents_status_log_tbl[0].forwarded_to != null" v-html=" retDivSecClus(docs.documents_status_log_tbl[0].division,docs.documents_status_log_tbl[0].section,docs.documents_status_log_tbl[0].cluster,1)"></p>
												<p v-if="docs.documents_status_log_tbl[0] != null && docs.documents_status_log_tbl[0].forwarded_to != null" class="text-xs text-gray-900">{{ frontEndDateFormat(docs.documents_status_log_tbl[0].created_at) }} </p>
												<p v-if="docs.documents_status_log_tbl[0].forwarded_to == null" class="text-xs text-gray-900">
													<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500 text-white">
														Pending
													</span>
												</p>
											</td>

											<td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
												<a @click="ViewingModal = true, viewParticulars(docs)" class="text-green-500 hover:text-green-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
												<br>
												<a @click="ForwardingModal = true, passDtrakNo(docs.dtrack_no)" class="text-yellow-500 hover:text-yellow-700 cursor-pointer">Forward <i class="fas fa-file-export"></i> </a>
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
								<span class="text-gray-500" v-html="retDiv(this.LogDocData.doc_current_location)"></span>	
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
						<div class="inline-flex gap-3 ml-auto">
							<span class="text-gray-500">Dtrack No.</span> <span class="text-green-500">{{ SpecificDocData.dtrack_no }}</span>
						</div>
					</section>
					<section class="flex gap-x-4 px-5 mt-2" v-if="ToggleDocsHistory_Particulars">
						<!-- This example requires Tailwind CSS v2.0+ -->
						<div class="py-2 align-middle inline-block min-w-full">
							<section class="border-b text-gray-500 flex justify-between items-center">
								<span class="text-1xl font-semibold">Particulars</span><br>
								<span class="text-xs font-light ml-auto">Created On: {{ SpecificDocData.created_at }}</span>	
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

					<section class="px-5 mt-2" v-if="!ToggleDocsHistory_Particulars">
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
										{{ history.created_at }}
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-html=" retDivSecClus(history.division,history.section,history.cluster,1)"></span>	
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

		<!-- Modal for Logging Document -->
		<modal :show="ForwardingModal" maxWidth="sm" >
			<div class="py-2">
				<form @submit.prevent="submitLogDocumentModal">
					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="text-gray-500">
							<span class="text-2xl font-semibold">Route document |</span> <span class="text-lg"> {{ this.DtrakNoHolder }} </span> <br>
							<span class="text-xs font-light">(This is for routing received documents only)</span>
						</div>
					</section>

					<section class="border-b border-gray-300 px-5 flex justify-between items-center">
						<div class="w-full block">
							<div class="block text-purple-500 my-2 text-base">
								Destination
							</div>
							<div class="block text-gray-500 mb-2">
								<label for="doctype" class="text-xs">Division</label>
								<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocDivisionData" @change='getSection()' required>
									<option v-for='divData in Division_List' :key="divData.value" :value='divData.id'>{{ divData.name }}</option>
								</select>
							</div>
							
							<div class="block text-gray-500 mb-2">
								<label for="doctype" class="text-xs">Section</label>
								<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocSectionData" @change='getCluster()'>
									<option v-for='secData in Section_List' :key="secData.value" :value='secData.id'>{{ secData.name }}</option>
								</select>
							</div>

							<div v-if="Cluster_List.length > 0 && ForwardDocForm.ForwardDocDivisionData == 4" class="block text-gray-500 mb-2">
								<label for="doctype" class="text-xs">Cluster</label>
								<select class="mt-1 py-2 bg-gray-50 border-b-2 border-t-0 border-l-0 border-r-0 rounded-xs w-full text-gray-800 focus:outline-none focus:ring-0" v-model="ForwardDocForm.ForwardDocClusterData">
									<option v-for='clusData in Cluster_List' :key="clusData.value" :value='clusData.id'>{{ clusData.name }}</option>
								</select>
							</div>

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
					</section>

					<section class="px-3 pt-3 pb-1 flex justify-between items-center">
						<div class="inline-flex gap-3 ml-auto">
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
	
    export default {
        components: {
            OfficeLayout,
            Modal,
			UploadImages,
        },
		props: ['LoggedDocuments','incomingDocuments','UsersDetails'],
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
					ForwardDocSectionData: 0,
					ForwardDocClusterData: 0,
				}),
				IncomingDtrackArray: [],
				DtrakNoHolder: "",
				SpecificDocData: [],
				OriginFname: "",
				OriginLname: "",
				LogDocData: null,
				ToggleErrorLogForm: null,
				Division_List: [],
				Section_List: [],
				Cluster_List: [],
			};
		},
		computed: {	
		},
		methods: {
			closeModal(type){
				// ViewingModal
				if(type == 1){
					this.ViewingModal = false;
					this.ViewingModalParticulars = false;
					this.SpecificDocData = [];
					console.log(this.SpecificDocData);
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
				console.log(data);
				this.SpecificDocData = data;
				console.log(this.SpecificDocData.users_details.fname);
				this.OriginFname = this.SpecificDocData.users_details.fname;
				this.OriginLname = this.SpecificDocData.users_details.lname;
			},
			passDtrakNo(data){
				console.log("passDtrakNo");
				this.DtrakNoHolder = data;
				console.log(this.DtrakNoHolder);
			},
			openImageInNewTab(event){
				var largeImage = document.getElementById(event.currentTarget.id);
				var url=largeImage.getAttribute('src');
				window.open(url,'_blank','docHistory');
			},
			formatAmount(value) {
				let val = (value/1).toFixed(2).replace(',', '.')
				return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
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
                   division_id: this.ForwardDocForm.ForwardDocDivisionData
                 }
              }).then(function(response){
                    this.Section_List = response.data;
					console.log(response.data);
                }.bind(this));
            },
			getCluster: function() {
                axios.get('/getCluster',{
                 params: {
                   section_id: this.ForwardDocForm.ForwardDocSectionData
                 }
              }).then(function(response){
                    this.Cluster_List = response.data;
					console.log(response.data);
                }.bind(this));
            },
			checkDtrackNo(event){
				for(var i=0; i<this.incomingDocuments.length; i++) {
					console.log(this.incomingDocuments[i].dtrack_no);
					if(this.incomingDocuments[i].dtrack_no.toString() == this.LogForm.logDtrackNo.toString()) {
						// console.log("MATCHED");
						this.ToggleErrorLogForm = true;
						this.LogDocData = this.incomingDocuments[i];
						console.log(this.incomingDocuments[i]);
					}else{
						this.ToggleErrorLogForm = false;
						this.LogDocData = [];
						// console.log("UNMATCHED");
					}
				}
			},
			retDiv(currentLocation){
				var arr = currentLocation.split(',');
				arr
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
				return divs[arr[0]] +'<br/>'+ secs[arr[1]] +"<br/>"+ cluster[arr[2]];
			},
			retDivSecClus(div,sec,clus,type){
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
			submitLogDocumentModal(){
				this.$inertia.post(route('office.logdoc'), this.LogForm, {
 					onSuccess: (res) => this.LogDocumentModal = false,
					onFinish: () => this.LogForm.reset(),
				}).then(function (response) {
					console.log(response);
            	}.bind(this));
			},
			submitForwardingModal(){
				console.log("submitForwardingModal");
			},
			frontEndDateFormat: function(date) {
				return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        	},
			forIndex(index) {
				return index+1
			},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
			// viewDocsHistory(){
			// 	console.log("viewDocsHistory");
			// },
			// resetModal(){
			// 	this.ViewingModalParticulars = true;
			// 	this.ViewingModalDocHistory = false;
			// },
			// openImageInNewTab(event){
			// 	var largeImage = document.getElementById(event.currentTarget.id);
			// 	var url=largeImage.getAttribute('src');
			// 	window.open(url,'_blank','docHistory');
			// },		
			// viewParticulars(data){
			// 	console.log("viewParticulars");
			// 	console.log(data);
			// 	this.SpecificDocData = data;
			// },
		},
		created: function(){
			this.getDivision()
        }
    };
</script>
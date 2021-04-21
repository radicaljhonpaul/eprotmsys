<template>
	<office-layout>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<div class="lg:flex lg:items-center lg:justify-between mb-5">
					<div class="flex-1 min-w-0">
						<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
							Forwarded Documents
						</h2>
						<div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6"></div>
					</div>
					<div class="mt-5 flex lg:mt-0 lg:ml-4">
						<span class="sm:ml-3">
							<!-- <button v-if="incomingDocuments.length > 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-white text-green-600 hover:bg-green-700 hover:text-white focus:outline-none border-green-700">
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ incomingDocuments.length }}</div>
							</button>
 
							<button v-if="incomingDocuments.length == 0" @click="LogDocumentModal = true" type="button" class="inline-flex items-center px-4 py-2 border-2 border-transparent rounded-md shadow-sm text-sm font-medium bg-gray-500 text-white focus:outline-none border-gray-700" disabled>
								<i class="fas fa-file-import"></i> &nbsp;	
								Incoming Docs &nbsp; <div style="padding-top: 0.1em; padding-bottom: 0.1rem" class="text-xs px-2 bg-red-500 text-white rounded-full">{{ incomingDocuments.length }}</div>
							</button> -->
						</span>
					</div>
				</div>

                <!-- Table -->
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
											Forwarded
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Assessment
										</th>
										<th scope="col" class="relative px-6 py-3">
											<span class="sr-only">View</span>
										</th>
										</tr>
									</thead>
									<tbody class="bg-white divide-y divide-gray-200">
										<tr v-if="!OutgoingDocuments.data.length">
											<td colspan="6" class="text-center border font-bold text-red-500 text-lg py-5">
												No Data Available
											</td>
										</tr>
										<tr v-show="OutgoingDocuments.data.length > 0" v-for="docs in OutgoingDocuments.data" :key="docs.created_at" class="border-r-8 border-green-500">
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="flex items-center">
													<div class="flex-shrink-0 h-10 w-10">
														<img class="h-10 w-10 rounded-full" :src="'/storage/'+$page.props.user.profile_photo_path" alt="">
													</div>
													<div class="ml-4">
														<div class="text-sm font-medium text-gray-900">
															<span v-if="docs.documents_tbl.users_details.gender == 'Male'">
																Mr.
															</span>	
															<span v-else>
																Ms.
															</span>	
															{{ docs.documents_tbl.users_details.fname }} {{ docs.documents_tbl.users_details.lname }}
														</div>
													</div>
												</div>
											</td>
											<td class="px-6 py-4 whitespace-nowrap">
												<div class="text-xs text-gray-900">{{ docs.documents_tbl.doc_type }} </div>
												<div class="text-xs text-gray-500">{{ docs.documents_tbl.documents_particulars_tbl.length }} Particulars</div>
												<div class="text-xs text-red-500">DTRAK No. {{ docs.documents_tbl.dtrack_no }}</div>
												<div class="text-xs text-yellow-500">Received On</div>
												<p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.created_at) }} </p>
											</td>
											
											<!-- If received & forwarded -->
											<td v-if="docs.documents_tbl.forwarded_to != null" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
												<p class="text-gray-900" v-html=" retDiv(docs.documents_tbl.forwarded_to)"></p>
												<div class="text-xs text-yellow-500">Forwarded On</div>
                                                <p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.updated_at) }} </p>
                                            </td>
											<td v-if="docs.documents_tbl.forwarded_to != null" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                <p class="text-xs text-gray-900">{{ dateDifference(docs.created_at,docs.updated_at) }} </p>
                                            </td>
											<!-- If received & forwarded -->

											<!-- If received but not yet forwarded -->
											<td v-if="docs.documents_tbl.forwarded_to == null" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
												<p class="text-red-500">Received but not yet forwarded</p>
												<div class="text-xs text-yellow-500">Received date</div>
                                                <p class="text-xs text-gray-900">{{ frontEndDateFormat(docs.updated_at) }} </p>
											</td>
											<td v-if="docs.documents_tbl.forwarded_to == null" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                <p class="text-xs text-gray-900"> Not yet applicable </p>
                                            </td>
											<!-- If received but not yet forwarded -->

											<td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
												<a @click="ViewingModal = true, viewParticulars(docs.documents_tbl), toggleParticularsDocHistory()" class="text-green-500 hover:text-green-700 cursor-pointer">View <i class="fas fa-eye"></i> </a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Modal for Viewing Document -->
		<modal :show="ViewingModal" >
			<div class="py-2">
				<form>
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
										<span v-html=" retDivSecClus(history.division,history.section,history.cluster,1)"></span>	
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-if="history.doc_notes != null"> {{ history.doc_notes }} </span>
										<span v-if="history.doc_notes == null" class="text-red-500"> Not applicable </span>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-if="history.document_status != null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
											<span> {{ history.document_status }} </span>
										</span>
										<span v-if="history.document_status == null" class="text-red-500"> Not applicable </span>
									</td>
									<td class="px-2 py-2 whitespace-nowrap">
										<span v-if="history.img_logs_tbl.length == 0" class="text-red-500 text-left"> Not applicable </span>
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
	
    export default {
        components: {
            OfficeLayout,
            Modal,
			UploadImages,
        },
		props: ['OutgoingDocuments','UsersDetails'],
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
				console.log(data);
				this.SpecificDocData = data;
				console.log(this.SpecificDocData.users_details.fname);
				this.OriginFname = this.SpecificDocData.users_details.fname;
				this.OriginLname = this.SpecificDocData.users_details.lname;
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
			retDiv(data){
				var arr = data.split(',');
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
			frontEndDateFormat: function(date) {
				return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        	},
			dateDifference: function(startDate,endDate) {
                var duration = moment.duration(moment(endDate).diff(moment(startDate)));
                var arr = [];
                var days, hours, min, sec, milisec;
                if(duration.asDays() < 1){
                    arr.push(1);
                    hours = duration.asHours();
                    arr.push(parseInt(hours));
                    if(hours % 1 > 0){
                        min = moment.duration(hours).asMinutes();
                        if(min % 1 > 0){
                            arr.push(parseInt(min));

                            sec = moment.duration(min).asSeconds();
                            if(min % 1 > 0){
                                arr.push(parseInt(sec));
                            }
                        }else;
                    }else;

                }else{
                    arr.push(2);
                    arr.push(days);
                    hours = duration.asHours();
                    arr.push(parseInt(hours));
                    if(hours % 1 > 0){
                        min = moment.duration(hours).asMinutes();
                        if(min % 1 > 0){
                            arr.push(parseInt(min));

                            sec = moment.duration(min).asSeconds();
                            if(min % 1 > 0){
                                arr.push(parseInt(sec));
                            }
                        }else;
                    }else;
                }
                console.log(arr);

                if(arr[0] == 1){
                    return arr[1]+' Hrs, '+ arr[2]+' min, '+ arr[3]+' sec';
                }else{
                    return arr[1]+' Days, '+ arr[2]+' Hrs,'+ arr[3]+' min';
                }
                
        	},
			forIndex(index) {
				return index+1
			},
			toggleParticularsDocHistory(){
				this.ToggleDocsHistory_Particulars = !this.ToggleDocsHistory_Particulars;
			},
		},
		created: function(){
        }
    };
</script>
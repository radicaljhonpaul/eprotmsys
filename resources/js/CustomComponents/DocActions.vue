<template>
    <option v-for="option in Doc_Action_Options" :key="option.value" :value="option.value">
        {{ option.text }}
    </option>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
				Doc_Action_Options: [
					{ text:"For Abstract as Read", value: "For Abstract as Read" },
					{ text:"For Action", value: "For Action" },
					{ text:"For Action Taken", value: "For Action Taken" },
					{ text:"For Approval", value: "For Approval" },
					{ text:"For ARD's approval", value: "For ARD's approval" },
					{ text:"For awarding", value: "For awarding" },
					{ text:"For CAF & Signature", value: "For CAF & Signature" },
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
            }
        },
        created(){
        },
        methods:{

        }
    }
</script>
<template>
    <span v-html="retDocDestination(Destination)"></span>	
</template>

<script>
    export default {
        props: {
            Destination: null,
        },
        data() {
            return {
				
            }
        },
        created(){
        },
        methods:{
            retDocDestination(destination){

                var data_arr = destination.split(',');

                var division = [
                    "",
                    "RD/ARD",
                    "LHSD",
                    "MSD",
                    "RLED",
                ]

                var cluster = [
                    "",
                    "GOVERNANCE CLUSTER",
                    "INFECTIOUS CLUSTER",
                    "FAMILY HEALTH CLUSTER",
                    "NonCom/NVBSP/ENVIRONMENTAL CLUSTER",
                    "FINANCE SECTION",
                ]

                var office = [
                    "",
                    "RD's Office",
                    "ARD's Office",
                    "Planning",
                    "PACD",
                    "Legal",
                    "QMS",
                    "RESU-HEMS",
                    "RESEARCH",
                    "PolyClinic",
                    "PDOHO-ADN",
                    "CDOHO",
                    "PDOHO-ADS",
                    "PDOHO-PDI",
                    "PDOHO-SDN",
                    "PDOHO-SDS",
                    "LHSD Division Chief Office",
                    "Governance Cluster Head Office",
                    "BHW",
                    "IP-GIDA",
                    "LIPH",
                    "UHC & HLGP",
                    "PD",
                    "MAIP",
                    "HFEP",
                    "Helpline Desk",
                    "Infectious Cluster",
                    "Rabies & Leprosy",
                    "HIV",
                    "TB",
                    "Filariasis/Schisto/STH/FWBD",
                    "Malaria",
                    "EREID",
                    "Dengue",
                    "Hospital Operations",
                    "Family Health Cluster Head Office",
                    "MNCHN",
                    "FP",
                    "EPI and Child Injury",
                    "NBS",
                    "Adolescent",
                    "Nutrition",
                    "Oral Health",
                    "Sr. Citizen",
                    "NonCom/NVBSP/Environmental Cluster Head Office",
                    "NonCommunicable Diseases",
                    "Person with Disability",
                    "Environmental & Occupational Health",
                    "NVBSP",
                    "MSD Division Chief Office",
                    "Health Promotion",
                    "HRDMU",
                    "KMICT/Records",
                    "BACSec",
                    "Procurement Unit",
                    "Finance Receiving Office",
                    "Cashier",
                    "Accounting",
                    "Budget",
                    "Supply Unit",
                    "Transport",
                    "General Services",
                    "GAD",
                    "RLED Division Chief"
                ]

                if(data_arr[1] == 0){
                    return division[data_arr[0]] +"<br/>"+ office[data_arr[2]];
                }else if(data_arr[2] == 0){
                    return division[data_arr[0]] +"<br/>"+ cluster[data_arr[1]];
                }else{
                    // return division[data_arr[0]] +"<br/>"+ cluster[data_arr[1]] +"<br/>"+ office[data_arr[2]];
                    return "<p class='mb-0'>"+ division[data_arr[0]] +"</p>" + "<p class='mb-0'>"+ cluster[data_arr[1]] +"</p>" + "<p class='mb-0'>"+ office[data_arr[2]] +"</p>";
                }
               
            },
        }
    }
</script>
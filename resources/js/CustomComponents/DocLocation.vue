<template>
    <span v-html="retDocLocation(Division,Cluster,Office,Type)"></span>	
</template>

<script>
    export default {
        props: {
            Division: null,
            Cluster: null,
            Office: null,
            Type: null,
        },
        data() {
            return {
				
            }
        },
        created(){
        },
        methods:{
            retDocLocation(div,clus,off,type){

                var type2 = [];
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

                if(type == 2){
                    // if type 2 -> receives div then undefined 2 + 1 params,
                    var answ = div.split(',');
                    answ.forEach(function(obj){
                        type2.push(parseInt(obj));
                    });
                    if(clus == 0){
                        return division[type2[0]] +"<br/>"+ office[type2[2]];
                    }else if(off == 0){
                        return division[type2[0]] +"<br/>"+ cluster[type2[1]];
                    }else{
                        return division[type2[0]] +"<br/>"+ cluster[type2[1]] +"<br/>"+ office[type2[2]];
                    }
                }else{
                    console.log("Doclocation");
                    if(clus == 0){
                        return division[div] +"<br/>"+ office[off];
                    }else if(off == 0){
                        return division[div] +"<br/>"+ cluster[clus];
                    }else{
                        return division[div] +"<br/>"+ cluster[clus] +"<br/>"+ office[off];
                    }
                }
            },
        }
    }
</script>
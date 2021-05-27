//Mylib.js
import moment from 'moment';

// this (vue instance) is passed as that , so we
// can read and write data from and to it as we please :)
let closeModal = (that, type) => {
    // ViewingModal
    if(type == 1){
      that.ViewingModal = false;
      // that.ViewingModalParticulars = false;
      that.SpecificDocData = [];
      
    // LogDocumentModal
    }else if(type == 2){
      that.LogDocumentModal = false;
      that.LogForm.logDtrackNo = null;
      that.ToggleErrorLogForm = null;
    // ForwardingModal
    }else if(type == 3){
      that.ForwardingModal = false;
    }else if(type == 4){
      that.CreateDocumentModal = false;
    }else if(type == 5){
      that.FilteringModal = false;
    }
};

let viewParticulars = (that,data) => {
  console.log("viewParticulars");
  console.log(data);
  that.SpecificDocData = data;
  that.OriginFname = that.SpecificDocData.users_details.fname;
  that.OriginLname = that.SpecificDocData.users_details.lname;
  console.log(that.SpecificDocData.users_details.fname);
  console.log(that.SpecificDocData.users_details.lname);

};

let openImageInNewTab = (event) => {
  var largeImage = document.getElementById(event.currentTarget.id);
  var url=largeImage.getAttribute('src');
  window.open(url,'_blank','docHistory');
};

let formatAmount = (value) => {
  let val = (value/1).toFixed(2).replace(',', '.')
  return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
};

let frontEndDateFormat = (date_data) => {
  return moment(date_data).format('MMM Do YYYY, h:mm:ss a');
};

let getOfficesDivision = (that) => {
  axios.get('/getOfficesDivision')
  .then(function (response) {
    that.Division_List = response.data;
    console.log(that.Division_List);
  }.bind(that));
};

let getOfficesCluster = (that,cluster,division) => {
  axios.get('/getOfficesCluster',{
    params: {
      cluster_id: cluster,
      division_id: division
    }
  }).then(function(response){
    that.Cluster_List = response.data;
    console.log(that.Cluster_List);
   }.bind(that));
};

let getOffices = (that,section,division) => {
  axios.get('/getOffices',{
    params: {
      division_id: division,
      cluster_id: section
    }
  }).then(function(response){
      that.Office_List = response.data;
      console.log(response.data);
   }.bind(that));
};

let dateDifference = (startDate,endDate) => {
  var duration = moment.duration(moment(endDate).diff(moment(startDate)));
  var finalArr = [];

  if(startDate == endDate){
    return "0 sec";
  }

  if(duration.get('days') > 0){
    finalArr.push(duration.get('days')+' day(s) ');
  }else;

  if(duration.get('hours') > 0){
    finalArr.push(duration.get('hours')+' Hr(s) ');
  }else;

  if(duration.get('minutes') > 0){ 
    finalArr.push(duration.get('minutes')+' min ');
  }else;

  if(duration.get('seconds') > 0){ 
    finalArr.push(duration.get('seconds')+' sec ');
  }else;

  if(duration.get('milliseconds') > 0){ 
    finalArr.push(duration.get('milliseconds')+' ms ');
  }else;

  var finalData="";
  for(var i=0; i < finalArr.length; i++){
    finalData = finalData.concat(finalArr[i]);
  }

  return finalData;
};

let dateAs = (time) => {
  var duration = moment.duration(moment(time));
  var finalArr = [];

  if(duration.get('days') > 0){
    finalArr.push(duration.get('days')+' days ');
  }else;

  if(duration.get('hours') > 0){
    finalArr.push(duration.get('hours')+' Hrs ');
  }else;

  if(duration.get('minutes') > 0){ 
    finalArr.push(duration.get('minutes')+' min ');
  }else;

  if(duration.get('seconds') > 0){ 
    finalArr.push(duration.get('seconds')+' sec ');
  }else;

  if(duration.get('milliseconds') > 0){ 
    finalArr.push(duration.get('milliseconds')+' ms ');
  }else;

  var finalData="";
  for(var i=0; i < finalArr.length; i++){
    finalData = finalData.concat(finalArr[i]);
  }

  return finalData;
};

let locationForExporting = (destination) => {
  if(destination == null){
    return "Not Applicable";
  }else{
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
        return division[data_arr[0]] +"-"+ office[data_arr[2]];
    }else if(data_arr[2] == 0){
        return division[data_arr[0]] +"-"+ cluster[data_arr[1]];
    }else{
        return division[data_arr[0]] +"-"+ cluster[data_arr[1]] +"-"+ office[data_arr[2]];
    }
  }
};

var xport = {
  closeModal: closeModal,
  viewParticulars: viewParticulars,
  openImageInNewTab: openImageInNewTab,
  formatAmount: formatAmount,
  frontEndDateFormat: frontEndDateFormat,
  dateDifference: dateDifference,
  getOfficesDivision: getOfficesDivision,
  getOfficesCluster: getOfficesCluster,
  getOffices: getOffices,
  dateAs: dateAs,
  locationForExporting: locationForExporting,
};

export default xport;

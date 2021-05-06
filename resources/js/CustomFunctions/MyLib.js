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
  return moment(date_data).format('MMMM Do YYYY, h:mm:ss a');
};

let retDiv = (currentLocation) => {
  var arr = currentLocation.split(',');

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
    "BAC",
    ]
    var cluster = [
    "",
    "PERSONNEL",
    "TRAINING",
    "HEALTH PROMOTION",
    "KNOWLEDGE MNGT. CLUSTER",
    "DEPLOYMENT PROG. CLUSTER",
    "BUDGET",
    "ACCOUNTING",
    "CASHIER",
    ]
    return divs[arr[0]] +' | '+ secs[arr[1]] +"<br/>"+ cluster[arr[2]];
};

let retDivSecClus = (div,sec,clus,type) => {

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
    "BAC",
  ]
  var cluster = [
    "",
    "PERSONNEL",
    "TRAINING",
    "HEALTH PROMOTION",
    "KNOWLEDGE MNGT. CLUSTER",
    "DEPLOYMENT PROG. CLUSTER",
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
    return divs[type2[0]] +' | '+ secs[type2[1]] +"<br/>"+ cluster[type2[2]];
  }else{
    return divs[div] +' | '+ secs[sec] +"<br/>"+ cluster[clus];
  }
  
};

let getDivision = (that) => {
  axios.get('/getDivision')
  .then(function (response) {
    that.Division_List = response.data;
    console.log(that.Division_List);
  }.bind(that));
};

let getSection = (that,division) => {
  axios.get('/getSection',{
    params: {
      division_id: division
    }
  }).then(function(response){
    that.Section_List = response.data;
    console.log(that.Section_List);
   }.bind(that));
};

let getCluster = (that,section) => {
  axios.get('/getCluster',{
    params: {
      section_id: section
    }
  }).then(function(response){
      that.Cluster_List = response.data;
      console.log(response.data);
   }.bind(that));
};

let dateDifference = (startDate,endDate) => {
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
};


var xport = {
  closeModal: closeModal,
  viewParticulars: viewParticulars,
  openImageInNewTab: openImageInNewTab,
  formatAmount: formatAmount,
  getDivision: getDivision,
  getSection: getSection,
  getCluster: getCluster,
  frontEndDateFormat: frontEndDateFormat,
  retDiv: retDiv,
  retDivSecClus: retDivSecClus,
  dateDifference: dateDifference,
};

export default xport;

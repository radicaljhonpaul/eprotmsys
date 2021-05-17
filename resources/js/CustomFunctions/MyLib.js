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

  console.log("duration");
  console.log(duration);
  console.log(duration.get('days'));
  console.log(duration.get('hours'));
  console.log(duration.get('minutes'));
  console.log(duration.get('seconds'));
  console.log(duration.get('milliseconds'));

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

  console.log("duration");
  console.log(duration);
  console.log(duration.get('days'));
  console.log(duration.get('hours'));
  console.log(duration.get('minutes'));
  console.log(duration.get('seconds'));
  console.log(duration.get('milliseconds'));

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
};

export default xport;

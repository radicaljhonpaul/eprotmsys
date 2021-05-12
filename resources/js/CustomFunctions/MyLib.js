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

let dateAs = (time) => {
  var duration = moment.duration(moment(time));
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

                  milisec = moment.duration(sec).asMilliseconds();
                  if(sec % 1 > 0){
                      arr.push(parseInt(milisec));
                  }
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

                  milisec = moment.duration(sec).asMilliseconds();
                  if(sec % 1 > 0){
                      arr.push(parseInt(milisec));
                  }
              }
          }else;
      }else;
  }
  console.log(arr);
  if(arr[0] == 1){
    var finalArr = [];
    console.log("arr[0]");
    if(arr[1] > 0){
      finalArr.push(arr[1]+' Hrs ');
    }else;

    if(arr[2] > 0){
      finalArr.push(arr[2]+' min ');
    }else;

    if(arr[3] > 0){
      finalArr.push(arr[3]+' sec ');
    }else;

    if(arr[4] > 0){
      finalArr.push(arr[4]+' ms ');
    }else;

    var finalData="";
    for(var i=0; i < finalArr.length; i++){
      finalData = finalData.concat(finalArr[i]);
    }
      return finalData;
  }else{
    console.log("arr[1]");
    if(arr[1] > 0){
      finalArr.push(arr[1]+' Days ');
    }else;

    if(arr[2] > 0){
      finalArr.push(arr[2]+' Hrs ');
    }else;

    if(arr[3] > 0){
      finalArr.push(arr[3]+' min ');
    }else;

    if(arr[4] > 0){
      finalArr.push(arr[4]+' sec ');
    }else;

    if(arr[5] > 0){
      finalArr.push(arr[5]+' ms ');
    }else;

    var finalData="";
    for(var i=0; i < finalArr.length; i++){
      finalData = finalData.concat(finalArr[i]);
    }
    return finalData;
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
};

export default xport;

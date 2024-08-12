const ctx = document.getElementById('myChart');


let myLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let myData1  = [12, 19, 3, 5, 2, 3];
let myData2  = [10, 13, 17, 15, 1, 2];

new Chart(ctx, {
  type: 'line',
  data: {
    labels: myLabels,
    datasets: [{
      label: 'المكسب',
      data: myData1,
      borderWidth: 3
    }, {
      label: 'الأعضاء',
      data: myData2,
      borderWidth: 3
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
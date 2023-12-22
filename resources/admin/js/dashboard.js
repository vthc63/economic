$(document).ready(function(){
  var days = JSON.parse($('#data-statistics').attr('days'));
  var parameters = JSON.parse($('#data-statistics').attr('parameters'));
  $(function () {
    //-------------
    //- BAR CHART -
    //-------------
    var areaChartData = {
      labels  : days,
      datasets: [
        {
          label               : 'doanh thu',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : parameters
        },
      ]
    }

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var barChartData = $.extend(true, {}, areaChartData);
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
    var stackedBarChartData = $.extend(true, {}, barChartData);

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    });
  });

  // chart best selling products
  var lableBestSellProduct = JSON.parse($('#pieChart').attr('label'))
  var dataBestSellProduct = JSON.parse($('#pieChart').attr('data'))
  var donutData        = {
    labels: lableBestSellProduct,
    datasets: [
      {
        data: dataBestSellProduct,
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#CC6699', '#00DD00', '#001100', '#FFFF33'],
      }
    ]
  }

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })

  // chart best review product

  var lableBestSellProduct = JSON.parse($('#bestReview').attr('label'))
  var dataBestSellProduct = JSON.parse($('#bestReview').attr('data'))
  var donutData        = {
    labels: lableBestSellProduct,
    datasets: [
      {
        data: dataBestSellProduct,
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#CC6699', '#00DD00', '#001100', '#FFFF33'],
      }
    ]
  }

  var pieChartCanvas = $('#bestReview').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })
});
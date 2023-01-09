$('document').ready(function(){

  function loadChart(data)
  {
    var ctx = $('#transactions')[0].getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
      datasets: [{
        label: 'Расход $',
        data: data.minus,
        borderColor: 'red',
        backgroundColor: 'red',
        fill: false,
      },
      {
        label: 'Доход $',
        data: data.plus,
        borderColor: 'blue',
        backgroundColor: 'blue',
        fill: false,
      }]
    },
    options: {
      responsive: true,
      hoverMode: 'index',
      stacked: false,
      title: {
        display: true,
        text: 'Транзакции '+data.year
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          },
          // grid line settings
          gridLines: {
            drawOnChartArea: false, // only want the grid lines for one axis to show up
          }
        }]
      },

    }
  });
  }
  function getStatisticTransactions()
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/statistic/transactions/',
      dataType: 'json',
      success: function(data){
        loadChart(data);
      }
    });
  }
  getStatisticTransactions();
});

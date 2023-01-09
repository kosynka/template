$('document').ready(function()
{
  function getStatisticProfit()
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/statistic/profit',
      dataType: 'json',
      success: function(data){
        loadChart(data);
      }
    });
  }
  function loadChart(data)
  {
    var ctx = $('#incomes')[0].getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            datasets: [{
                label: 'Прибыль $',
                data: data,
                backgroundColor: 'GREEN',
                borderColor: 'GREEN',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
  }

  getStatisticProfit();
});



$('document').ready(function()
{
  function getStatisticAuth()
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/statistic/visits',
      dataType: 'json',
      success: function(data){
        loadChart(data);
      }
    });
  }
  function loadChart(data)
  {
    var ctx = $('#authorization')[0].getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            datasets: [{
                label: 'Посещений',
                data: data,
                backgroundColor: 'RED',
                borderColor: 'RED',
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

  getStatisticAuth();
});

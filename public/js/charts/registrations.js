$('document').ready(function()
{
  function getStatisticRegistration()
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/statistic/registers',
      dataType: 'json',
      success: function(data){
        loadChart(data);
      }
    });
  }
  function loadChart(data)
  {
    var ctx = $('#registration')[0].getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            datasets: [{
                label: 'Зарегистрированных',
                data: data,
                backgroundColor: '#4ECDC4',
                borderColor: '#64c3c2',
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

  getStatisticRegistration();
});

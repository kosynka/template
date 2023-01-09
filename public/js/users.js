$('document').ready(function()
{
  $('#country_id').change(function()
  {
    country_id = $('#country_id').val();
    loadCity(country_id)
  });

  function loadCity(country_id)
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/'+country_id+'/city',
      dataType: 'json',
      success: function(data)
      {
        var options = '<option selected value="">---</option>';
        $(data).each(function(index, value) { options += '<option value="' + value.city_id + '">' + value.name + '</option>';});
        $('#city_id').html(options);
      }
    });
  }
  $(window).on('keydown', function(e) {
    if (e.which == 13)
    {
      var text = $('#text').val();
      var country_id = $('#country_id').val();
      var city_id = $('#city_id').val();
      $('.users').text(' ');
      $.ajax({
        type: 'GET',
        url: '/ajax/users/search',
        data: {'text' : text, 'country_id' : country_id, 'city_id' : city_id},
        dataType: 'json',
        success: function(data)
        {
          var arr = '';
          $(data.users).each(function(index, value)
          {
            arr +=  '<tr>';
            arr +=  "<td>"+value.id+"</td>";
            arr +=  '<td><a href="profile.html">'+value.email+'</a></td>';
            arr +=  "<td>"+value.f+' '+value.i+' '+value.o+"</td>";
            arr +=  '<td>'+value.age_date+'</td>';
            arr +=  '<td><a href="/users/'+value.id+'" class="btn btn-primary btn-xs">Посмотреть</a></td>';
            arr +=  '</tr>';
          });
          $('.users').html(arr);
        }
      });
    }
  });
  $('#city_id').change( function()
  {
    var text = '';
    var country_id = $('#country_id').val();
    var city_id = $('#city_id').val();
    $('.users').text(' ');
    $.ajax({
      type: 'GET',
      url: '/ajax/users/search',
      data: {'text' : text, 'country_id' : country_id, 'city_id' : city_id},
      dataType: 'json',
      success: function(data)
      {
        var arr = '';
        $('.users').text(' ');
        $(data.users).each(function(index, value)
        {
          arr +=  '<tr>';
          arr +=  "<td>"+value.id+"</td>";
          arr +=  '<td><a href="profile.html">'+value.email+'</a></td>';
          arr +=  "<td>"+value.f+' '+value.i+' '+value.o+"</td>";
          arr +=  '<td>'+value.age_date+'</td>';
          arr +=  '<td><a href="/users/'+value.id+'" class="btn btn-primary btn-xs">Посмотреть</a></td>';
          arr +=  '</tr>';
        });
        $('.users').html(arr);
      }
    });
  });
});

$('document').ready(function()
{
  $('#country').change(function()
  {
    var country_id = $('#country').val();
    loadCity(country_id);
  });
  function loadCity(country_id)
  {
    $.ajax({
      type: 'GET',
      url: '/ajax/'+country_id+'/city',
      dataType: 'json',
      success: function(data)
      {
        var options = '';
        $(data).each(function(index, value) { options += '<option value="' + value.city_id + '">' + value.name + '</option>';});
        $('#city').html(options);
      }
    });
  }
});

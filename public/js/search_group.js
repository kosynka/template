$('document').ready(function()
{
  $('#text').change(function()
  {
    alert('new text');
    var text = $('#text').val();

      $('.groups').text(' ');
      $.ajax({
        type: 'GET',
        url: '/ajax/groups/search',
        data: {'text' : text },
        dataType: 'json',
        success: function(data)
        {
          var arr = '';
          $(data.groups).each(function(index, value)
          {
            arr +=  '<tr>';
            arr +=  "<td>"+value.id+"</td>";
            arr +=  '<td><a href="profile.html">'+value.name+'</a></td>';
            arr +=  '<td><a href="/group/'+value.id+'" class="btn btn-primary btn-xs">Посмотреть</a></td>';
            arr +=  '</tr>';
          });
          $('.groups').html(arr);
        }
      });
  });
      
});
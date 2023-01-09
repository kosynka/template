$('document').ready(function()
{
  $('.feedback #look').click(function()
  {
    var id = $(this).attr('data-id');
    $.ajax({
      type: 'GET',
      url: '/ajax/feedback',
      data: {'id_claim': id},
      dataType: 'json',
      success: function(data)
      {
        $('.text-feedback').html(data.text);
        $('#send').attr('data-id', data.id);
        $('#send').attr('data-email', data.email);
      }
    });
  });
  $('#send').click(function()
  {
    var id = $(this).attr('data-id');
    var sender = $(this).attr('data-email');
    var answer = $('#text').val();

    $.ajax({
      type: 'GET',
      url: '/ajax/feedback/send',
      data: {'id': id, 'answer': answer, 'sender': sender},
      dataType: 'json',
      success: function(data)
      {
        $('#myModal').modal('toggle');
        $('.feedback[data-id='+id+']').remove();
      }
    });
  });
});

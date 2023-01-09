$('document').ready(function()
{
  // Принять паспорт
  $('body').on('click', 'tr #accept', function() 
  {
    var id = $(this).attr('data-id');
    var el = $(this).parent().parent();

    $.ajax({
      type: 'GET',
      url: '/ajax/passport/accept', //route
      data: {'id': id},
      dataType: 'json',
      success: function(){
        el.fadeOut(1000, function() { el.remove(); });
      }
    });
  });

  // Отклонить паспорт
  $('body').on('click', 'tr #decline', function() 
  {
    var id = $(this).attr('data-id');
    var el = $(this).parent().parent();

    $.ajax({
      type: 'GET',
      url: '/ajax/passport/decline', //route
      data: {'id': id},
      dataType: 'json',
      success: function(){
        el.fadeOut(1000, function() { el.remove(); });
      }
    });
  });
});

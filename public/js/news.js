$('document').ready(function()
{
  $('.news #look').click(function()
  {
    var id = $(this).attr('data-id');
    $('.modal-footer').attr('data-id', id);
    $('.modal-footer #add').attr('style', 'display: none');
    CKEDITOR.instances.editor1.setData('');
    $('#title').val('');
    $.ajax({
      type: 'GET',
      url: '/ajax/news',
      data: {'id': id},
      dataType: 'json',
      success: function(data)
      {
        $('#title').val(data.title);
        CKEDITOR.instances.editor1.insertHtml(data.text);
        $('#file').val(data.background);
        $('#type').val(data.type);
      }
    });
  });

  $('.modal-footer #delete').click(function()
  {
    var id = $('.modal-footer').attr('data-id');
    $.ajax({
      type: 'GET',
      url: '/ajax/news/delete',
      data: {'id': id},
      dataType: 'json',
      success: function(data)
      {
        $('#myModal').modal('toggle');
        $('.news[data-id='+id+']').remove();
      }
    });
  });

  $('.modal-footer #edit').click(function()
  {
    var id = $('.modal-footer').attr('data-id');
    var title = $('#title').val();
    var content = CKEDITOR.instances.editor1.getData();
    var type = $('#type').val();
    var background = $('#file').val();

    $.ajax({
      type: 'GET',
      url: '/ajax/news/edit',
      data: {'id': id, 'title': title, 'content': content, 'type': type, 'background': background},
      dataType: 'json',
      success: function()
      {
        $('.news[data-id='+id+'] .title').text(title);
        $('#myModal').modal('toggle');
      }
    });
  });

  $('#addNews').click(function()
  {
    $('.modal-footer #delete').attr('style', 'display: none');
    $('.modal-footer #edit').attr('style', 'display: none');
    $('.modal-footer #add').attr('style', 'display: block');
    $('#file').val('');
    $('#type').val('');
    $('.modal-footer #add').click(function()
    {
      var title = $('#title').val();
      var content = CKEDITOR.instances.editor1.getData();
      var type = $('#type').val();
      var background = $('#file').val();
      $.ajax({
        type: 'GET',
        url: '/ajax/news/add',
        data: {'title': title, 'content': content, 'type': type, 'background': background},
        dataType: 'json',
        success: function(data)
        {
          var news = '<tr class="news" data-id="'+data.id+'"><td>'+data.id+'</td><td class="title">'+title+'</td><td></td><td id="look" data-id="'+data.id+'"><a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Посмотреть</a></td></tr>';
          $('.allNews').append(news);
          $('#myModal').modal('toggle');
        }
      });
    });
  });

});

$(document).ready(function() {
    $('#summernote').summernote();
  });
  jQuery(function($) {
    $("#text").summernote({
    
     lang:'ru-RU',
     height:300,
     minHeight:200,
     maxHeight:400,
     focus:true,
     placeholder:'Введите данные',
   fontNames:['Arial','Times New Roman','Helvetica'],
     disableDragAndDrop:true
    
    });
   });
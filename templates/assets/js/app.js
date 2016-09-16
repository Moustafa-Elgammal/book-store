/**
 * Created by tone on 16/09/2016.
 */
jQuery(document).ready(function($){
    $('.download').click(function(){
        var file = $(this).attr('file-data');
        window.location.href = file;
    });


    $('.view-more').click(function(){
        var file = 'book.php?id='+$(this).attr('data-id');
        window.location.href = file;
    });
});
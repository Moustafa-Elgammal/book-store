/**
 * Created by tone on 16/09/2016.
 */
jQuery(document).ready(function($){
    $('.download').click(function(){
        var file = $(this).attr('file-data');
        window.location.href = file;
    });

    //open view the book content page
    $('.view-more').click(function(){
        var file = 'book.php?id='+$(this).attr('data-id');
        window.location.href = file;
    });

    /*
    *   reset the form values from the sign up form
     */
    $('#sign-cancel').click(function(ev){
        $('input').val('');
        ev.preventDefault();
    });


    $('#sign-up').click(function(ev){
        var data = $('#sign-up-form').serialize();
        var action= $('#sign-up-form').attr('action');

        $.ajax({
            method:'post',
            url:action,
            data:data
        }).done(function (data){
            var info=JSON.parse(data);
            if(info.status){
                $('#msg').html(info.msg);
                $('.alert').addClass('alert-success');
                $('.alert').removeClass('alert-danger');
                $('.alert').show();
                $('input').val('');
            }else{
                $('#msg').html(info.msg);
                $('.alert').addClass('alert-danger');
                $('.alert').removeClass('alert-success');
                $('.alert').show();
            }

        });

        ev.preventDefault();
    });

});
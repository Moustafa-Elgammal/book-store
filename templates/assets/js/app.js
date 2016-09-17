/**
 * Created by tone on 16/09/2016.
 */
jQuery(document).ready(function($){
    $('.download').click(function(){
        var bookID = $(this).attr('data-id');
        var file = $(this).attr('file-data');
        $.ajax({
            url:'download.php',
            method:'post',
            data:'book_id='+bookID
        }).done(function(data){
            var info = JSON.parse(data);
            if(info.status){
                window.open(file);
            }else{
                alert(info.msg);
            }
        });


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
                $('#msg').html(info.msg+'you can log in now <a style="color:#7b1fa2 " href="admin/login.php">Log In</a>');
                $('.alert').addClass('alert-success');
                $('.alert').removeClass('alert-danger');
                $('.alert').show();
                $('input').val('').delay(5000);
            }else{
                $('#msg').html(info.msg);
                $('.alert').addClass('alert-danger');
                $('.alert').removeClass('alert-success');
                $('.alert').show();
            }

        });

        ev.preventDefault();
    });

    /**
     * add book for user in interested
     */
    $('.want-read').click(function(){
        var bookID = $(this).attr('data-id');
        $.ajax({
            url:'wanttoread.php',
            method:'post',
            data:'book_id='+bookID
        }).done(function(data){
            var info = JSON.parse(data);
            if(info.status){
                alert(info.msg);
            }else{
                alert(info.msg);
            }
        });
    });

    /**
     * add review
     */

    $('#review').click(function(ev){
        var data = $('#review-form').serialize();

        $.ajax({
            url:'review.php',
            method:'post',
            data:data
        }).done(function(data){
            var info = JSON.parse(data);
            if(info.status){
                alert(info.msg);
                window.location.reload();
            }else{
                alert(info.msg);
            }
        });
        ev.preventDefault();
    });

    $('.loader_lg_page').fadeOut(5000);
});
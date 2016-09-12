jQuery(document).ready(function($){
    $('.msg_close').click(function(){
        $(this).parent().hide();
    });

    /*--------------admin area queries -------------*/

    /**
     * add new category
     */

    $("#add_cat").click(function(ev){

        var data = $("#add_cat_form").serialize();
        $.ajax({
            url:'addcategory.php',
            method:'post',
            data:data
        }).done(function(data){
            var reply = JSON.parse(data);
            if(reply.status){
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.msg').html(reply.msg);
                $('.alert').show();
            }else{
            $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-danger');
                $('.msg').html(reply.msg);
                $('.alert').show();
            }
        });

        ev.preventDefault();

    });
});
jQuery(document).ready(function($){
    $('.sub').css('display','block');
    $('.msg_close').click(function(){
        $(this).parent().hide();
    });


    $('#remove_image').click(function(){
        var file = $("#file_image").attr('src');
        $.ajax({
            url:'delete_file.php',
            method:'post',
            data:'file='+ file
        }).done(function(){
            $("#loaded-img").hide();
            $("#loaded-img").html("");
            $("#MyUploadForm").show();
            $("#output").html("");
            $("#remove_image").hide();
        });

    });


    /*--------------admin area queries -------------*/

    /**
     * add new category
     */

    $("#add_cat").click(function(ev){
        if($("#ajaxed_photo").val().length) {
            var data = $("#add_cat_form").serialize();
            $.ajax({
                url: $('#add_cat_form').attr('action'),
                method: 'post',
                data: data
            }).done(function (data) {
                var reply = JSON.parse(data);
                if (reply.status) {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.msg').html(reply.msg);
                    $('.alert').show();
                    $("input[type=text]").val("");
                    $("textarea").val("");
                    $("#loaded-img").html("");
                    $("#MyUploadForm").show();
                    $("#remove_image").hide();
                } else {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.msg').html(reply.msg);
                    $('.alert').show();
                }
            });
        }else{
            $('.alert').removeClass('alert-success');
            $('.alert').addClass('alert-danger');
            $('.msg').html("please select a cover");
            $('.alert').show();

        }

        ev.preventDefault();

    });

    /**
     * uploader Ajax
     */

    var options = {
        //   target:   '#output',   // target element(s) to be updated with server response
        beforeSubmit:  beforeSubmit,  // pre-submit callback
        success:       afterSuccess,  // post-submit callback
        uploadProgress: OnProgress, //upload progress callback
        resetForm: true        // reset the form after successful submit
    };

    $('#MyUploadForm').submit(function() {
        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation
        return false;
    });
//function after succesful file upload (when server response)
    function afterSuccess(data)
    {
        $('#submit-btn').show(); //hide submit button
        $('#loading-img').hide(); //hide submit button
        $('#progressbox').delay( 1000 ).fadeOut(); //hide progress
        var info = JSON.parse(data);
        if(info.status) {
            $("#output").text(info.msg);
            $("#loaded-img").html('<img id="file_image" width="100px" src="' + info.file + '" atl="img AjaX">');
            $("#ajaxed_photo").val(info.file);
            $("#loaded-img").show();
            $("#remove_image").show();
            $("#MyUploadForm").hide();

        }
        else
            $("#output").text(info.msg);
    }

//function to check file size before uploading.
    function beforeSubmit(){
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob)
        {

            if( !$('#FileInput').val()) //check empty input filed
            {
                $("#output").html("Are you kidding me?");
                return false
            }

            var fsize = $('#FileInput')[0].files[0].size; //get file size
            var ftype = $('#FileInput')[0].files[0].type; // get file type


            //allow file types
            switch(ftype)
            {
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                case 'application/pdf':
                    break;
                default:
                    $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                    return false
            }

            //Allowed file size is less than 5 MB (1048576)
            if(fsize>5242880)
            {
                $("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
                return false
            }
            $("#loaded-img").show();
            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");
        }
        else
        {
            //Output error to older unsupported browsers that doesn't support HTML5 File API
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
        }
    }

//progress bar function
    function OnProgress(event, position, total, percentComplete)
    {
        //Progress bar
        $('#progressbox').show();
        $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
        $('#statustxt').html(percentComplete + '%'); //update status text
        if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
    }
//function to format bites bit.ly/19yoIPO
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Bytes';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    /**
     * delete category request
     */
    $(".category-delete").click(function(){
        var id = $(this).attr('id-data');

        $.ajax({
            url:'deleteCategory.php',
            method:'post',
            data:'id='+id
        }).done(function(data){
            data = JSON.parse(data);
            if(data.status){
                $('#cat-'+id).remove();
            }else{
                alert("Refresh this page");
            }
        });
    });


    /**
     * delete book request
     */
    $(".book-delete").click(function(){
        var id = $(this).attr('id-data');

        $.ajax({
            url:'deletebook.php',
            method:'post',
            data:'id='+id
        }).done(function(data){
            data = JSON.parse(data);
            if(data.status){
                $('#book-'+id).remove();
            }else{
                alert("Refresh this page");
            }
        });
    });

});
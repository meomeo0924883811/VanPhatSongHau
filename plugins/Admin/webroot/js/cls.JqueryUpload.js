function clsJqueryUpload(){
    this.show_process = true;
    this.main_init = function(){
        this.bind_events();
    }
    //bind event
    this.bind_events = function() {
        var parentObj = this;
        $(document).on('click', 'a.image_delete', function(){
            var data_url = $(this).attr('data-url');
            if(typeof data_url !== 'undefined'){
                var wrapper_upload = $(this).attr('wrapper_upload');
                var $this = $(this);
                $.ajax({
                    url: upload_server + 'delete.php',
                    type:'post',
                    data:{data_url:data_url},
                    success:function(data){
                        if(data == 1)
                        {
                            var _this = $this;
                            _this.parent('p').remove();
                            $('.wrapper_upload_' + wrapper_upload).find('input[data-type="result"]').val('');
                            $('.wrapper_upload_' + wrapper_upload).find('input[data-type="result"]').change();
                        }
                        else
                        {
                            //alert("Can't delete image!");
                            var _this = $this;
                            _this.parent('p').remove();
                            $('.wrapper_upload_' + wrapper_upload).find('input[data-type="result"]').val('');
                            $('.wrapper_upload_' + wrapper_upload).find('input[data-type="result"]').change();
                        }
                    }
                });
            }
        });
    }

    this.upload_init = function(id, multiple, max_size){
        var parentObj = this;
        $('#'+id).fileupload({
            url: upload_server + 'index.php',
            dataType: 'json',
            add: function(e, data) {
                var uploadErrors = [];
                var acceptFileTypes = /^image\/(gif|jpe?g|png)$/i;
                if(data.originalFiles[0]['type'] && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                    uploadErrors.push('Not an accepted file type');
                }
                if(data.originalFiles[0]['size'] && data.originalFiles[0]['size'] > max_size && max_size > 0) {
                    uploadErrors.push('Filesize is too big (<'+max_size+' bytes)');
                }
                if(uploadErrors.length > 0) {
                    alert(uploadErrors.join("\n"));
                } else {
                    data.submit();
                }
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    var parent = $('div.wrapper_upload_'+id);
                    var msg = "";
                    if(typeof file.error === 'undefined')
                    {
                        var del = '<a href="javascript:void(0)" wrapper_upload="'+id+'" data-url="'+file.url+'" data-type="DELETE" class="image_delete"><img src="'+window_app.webroot+'plugins/jQueryFileUpload/img/del-icon.png" alt="X"/></a> ';
                        var img = '<img src="'+ window_app.webroot + file.thumbnailUrl+'"/>';
                        error = "<span style='color:green'>Success</span>";
                        msg =  del + img;
                        console.log(file);
                        if(multiple == 'multiple')
                        {
                            var data_url = '<input type="hidden" name="multi_'+id+'[]" value="'+upload_temp+file.name+'"/>';
                            msg += data_url;
                            ($('<p/>').html(msg)).appendTo('#upload_files_'+id);
                        }
                        else
                        {
                            jQueryUpload.autoDeleteImage(parent);
                            parent.find('#upload_files_'+id).html($('<p/>').html(msg));
                        }
                        parent.find('input[data-type="result"]').val(upload_temp + file.name);
                        parent.find('input[data-type="result"]').change();
                    }
                    else
                    {
                        error = "<span style='color:red'>" + file.error + "<span>";
                        msg = error;
                        if(multiple == 'multiple')
                        {
                            ($('<p/>').html(msg)).appendTo('#upload_files_'+id);
                        }
                        else
                        {
                            jQueryUpload.autoDeleteImage(parent);
                            parent.find('#upload_files_'+id).html($('<p/>').html(msg));
                        }
                        parent.find('input[data-type="result"]').val("");
                        parent.find('input[data-type="result"]').change();
                    }
                });
            },
            progressall: function (e, data) {
                if(parentObj.show_process == true){
                    var parent = $('div.wrapper_upload_'+id);
                    jQueryUpload.progressall(parent, e, data);
                }
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }

    this.progressall = function(parent,e,data){
        parent.find('.progress-bar').css('width', '0%');
        parent.find("#progress").fadeIn();
        var progress = parseInt(data.loaded / data.total * 100, 10);
        parent.find('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
        if(progress == 100){
            setTimeout(function(){parent.find("#progress").fadeOut();},1000);
        }
    }

    this.autoDeleteImage = function(parent){
        parent.find('.upload_files a').each(function(index, element){
            var data_url = $(this).attr('data-url');
            $.ajax({
                url: upload_server + '/delete.php',
                type:'post',
                data:{data_url:data_url},
                success:function(data){

                }
            });
        });
    }
}
var jQueryUpload = new clsJqueryUpload();

$(document).ready(function(){
    jQueryUpload.main_init();
});




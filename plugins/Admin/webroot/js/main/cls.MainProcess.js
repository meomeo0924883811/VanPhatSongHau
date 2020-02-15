function clsMainProcess(){
	this.is_ajaxSaving = false;

	this.main_init = function(){
		this.bind_events();
		this.runLibs();
        this.removeClickBtnDelete();
    };

	//bind event
	this.bind_events = function() {
        var self = this;
	    $(document).on('click','[link_to]',function(){
	    	var link_to = $(this).attr('link_to');
            window.location.href = link_to;
            return false;
		});
        $(document).on('click','[confirm_delete]',function(){
            var event_delete = $(this).attr('event_delete');
            var msg = "Are you sure you want to delete!";
            mainProcess.open_modal(msg, function(){
                $('#myModal').modal('hide');
                var form_name = event_delete.substring(event_delete.indexOf("post"), event_delete.indexOf("submit")-1);
                $('form[name='+form_name+']').submit();
            });
            return false;
        });
        $(document).on('blur','[conv_to_slug]',function(){
            var value = $(this).val();
            var field_id = $(this).attr('conv_to_slug');
            slug_value = self.convert_to_slug(value);
            $('#'+field_id).val(slug_value);
        });
    };

    this.removeClickBtnDelete = function(){
        $('a[confirm_delete]').each(function(i,e){
            var event_delete = $(e).attr('onclick');
            $(e).removeAttr('onclick');
            $(e).attr('event_delete', event_delete);
        });
    };

    this.open_modal = function(message, callback){
        $('#modal_body').html(message);
        if(callback && typeof(callback) == 'function')
        {
            $(document).on('click','#modal_accept',function(){
                callback();
            });
        }
        $('#myModal').modal('show');
    };

	this.get_data_form =  function(form_ids)
    {
        var parentObj = this;
        var params = {};
        var temp_name = ''
        $(form_ids).find("input[type=radio]:checked,input[type=checkbox], input[type='text'], input[type='hidden'],input[type='email'],input[type='password'], select, textarea").each(function()
        {
            //alert(this.name);
            if(this.type == 'checkbox')
            {
                if(temp_name != this.name)
                {
                    params[this.name] = parentObj.get_values_checkbox(this.name);
                    temp_name =  this.name;
                }
            }
            else
            {
                if(this.value != $(this).attr('placeholder'))
                {
                    params[this.name] = this.value;
                }
                else
                {
                    params[this.name] = '';
                }
            }

        });
        return params;
    };

    this.convert_to_slug = function( slug )
    {
        var str = slug;
        str= str.toLowerCase();
        str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ  |ặ|ẳ|ẵ/g,"a");
        str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
        str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
        str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ  |ợ|ở|ỡ/g,"o");
        str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
        str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
        str= str.replace(/đ/g,"d");
        str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
        str= str.replace(/^\-+|\-+$/g,"");
        //cắt bỏ ký tự - ở đầu và cuối chuỗi
        return str;
    }

    this.runLibs = function(){
        $(".generate-select2").select2();

        $('input#published-cinema-date').datetimepicker({
            format:'d/m/Y',
            timepicker:false,
            scrollInput: false
        });
        $('input#published-bluray-date').datetimepicker({
            format:'d/m/Y',
            timepicker:false,
            scrollInput: false
        });
        tinymce.init({
            selector:'.tinymce',
            height: 200,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
            //content_css: [
            //    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            //    '//www.tinymce.com/css/codepen.min.css'
            //],
            valid_elements : "*,*[*]",
            forced_root_block: false, // br instead of <P>
            force_p_newlines : false,
            relative_urls:false,
            external_filemanager_path: window_app.webroot_full + "plugins/ResponsiveFilemanager/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : window_app.webroot_full + "plugins/ResponsiveFilemanager/filemanager/plugin.min.js"}
        });
    }
}
var mainProcess = new clsMainProcess();

$(document).ready(function(){
    mainProcess.main_init();
});




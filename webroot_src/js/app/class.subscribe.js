SE.clsSubscribe = (function() {

    //INIT
    function init(){
        initEvent();
    }

    function initEvent()
    {

        for(let i = 1; i <= 3; i++) {

            let data_name = $('#hoten' + i);
            let data_phone = $('#sdt' + i);

            data_name.blur(function () {
               $(this).removeClass('error');
            });

            data_phone.blur(function () {
                $(this).removeClass('error');
            });

            $('#submit' + i).click(function (e) {
                e.preventDefault();
                if (data_name.val() === '') {
                    data_name.addClass('error');
                    return 0;
                }
                if (data_phone.val() === '' || !validatePhone(data_phone.val())) {
                    alert("Anh chị vui lòng kiểm tra số điện thoại.");
                    data_phone.addClass('error');
                    return 0;
                }
                SE.clsPopup.open('#loading');
                $.ajax({
                    url: window_app.webroot + 'subscribe',
                    type: 'post',
                    data: {
                        name: data_name.val(),
                        phone: data_phone.val()
                    },
                    success: function (data) {
                        let real_data = JSON.parse(data);
                        if(real_data.status == 1){
                            alert("Đăng ký thành công. Em sẽ liên lạc lại với anh/chị trong thời gian sớm nhất");
                            SE.clsPopup.closePopup('#loading');
                            data_name.text('');
                            data_phone.text('');
                        }
                        else if (real_data.status == 2) {
                            alert('Vui lòng thử lại');
                            SE.clsPopup.closePopup('#loading');
                        }
                        else {
                            alert('Đã tồn tại số điện thoại này, anh/chị vui lòng nhập một số điện thoại khác.');
                            data_phone.addClass('error');
                            SE.clsPopup.closePopup('#loading');
                        }
                    }
                });
            });
        }
    }

    //FUNCTIONS

    function validatePhone(phone) {
        var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        return vnf_regex.test(phone);
    }

    //RETURN
    return {
        init:init,
        initEvent:initEvent
    }
})();


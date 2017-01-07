(function ($) {
    'use strict';
    $('#sms-verification').on('click',
        function (e) {
            sendSMS(e);
        });

    function sendSMS(e) {
        e.preventDefault();

        var phone = $(".phone-number-verification").val();
        if (phone == '') {
            return;
        }
        var data = {"phone": phone}, url = $(this).attr('data-url');

        var self = $('#sms-verification');
        $.ajax({
            'url': url,
            'type': 'post',
            'data': data,
            'dataType': 'json',
            'success': function (result) {
                self.off('click');
                setRemainTime(self);
            },
            'error': function ($error) {
                alert(result.message);
            }
        });
    }

    function setRemainTime(self) {
        var time = 11;
        var InterValObj = setInterval(function () {
            self.css({
                'background-color':'#E7E7E7',
                'border':'none',
                'color':'#B5B5B5'
            });
            time--;
            self.html(time + 's后重发');
            if (time <= 1) {
                clearInterval(InterValObj);
                self.css({
                    'background-color':'transparent',
                    'border':'1px solid #A30003',
                    'color':'#A30003'
                });
                self.html('获取验证码');
                self.on('click', function (e) {
                    sendSMS(e);
                })
            }
        }, 1000);
    }
})(jQuery);


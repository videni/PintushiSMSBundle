(function ($) {
    'use strict';

    $('#sms-verification').on('click',
        function (e) {
            e.preventDefault();

            var phone = $(".phone-number-verification").val();
            if (phone == '') {
                return;
            }
            var data = {"phone": phone}, url=$(this).attr('data-url');

           var self = $(this);

            $.ajax({
                'url': url,
                'type': 'post',
                'data': data,
                'dataType': 'json',
                'success': function (result) {
                    self.html("30秒后重发");
                },
                'error': function ($error) {
                    alert(result.message);
                }
            });
        });

})(jQuery);

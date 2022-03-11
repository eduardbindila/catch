/**
 * Created by Malal91 and Haziel
 * Select multiple email by jquery.email_multiple
 * **/

(function($){

    $.fn.email_multiple = function(options) {

        let defaults = {
            reset: false,
            fill: false,
            data: null
        };

        let settings = $.extend(defaults, options);
        let email = "";

        return this.each(function()
        {


            if(settings.reset){
                $('.email-ids, .to-input, .all-mail, .enter-mail-id').remove()
            }


            $(this).after("<span class=\"to-input\"></span>\n" +
                "<div class=\"all-mail\"></div>\n" +
                "<input type=\"text\" name=\"email\" class=\"enter-mail-id form-control\" placeholder=\"Enter Email ...\" />");
            let $orig = $(this);
            //console.log($orig.val());
            let $element = $('.enter-mail-id');
             //console.log(email);
            $element.keydown(function (e) {
                $element.css('border', '');
                if (e.keyCode === 13 || e.keyCode === 32) {
                    let getValue = $element.val();
                    // console.log(email);
                    // console.log($element.val());
                    if (/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(getValue)){
                        $('.all-mail').append('<span class="email-ids"><span class="emailAddress">' + getValue + '</span><span class="cancel-email">x</span></span>');
                        $element.val('');

                        email += getValue + ','
                        //console.log(getValue);
                    } else {
                        $(this).css('border', '1px solid red')
                    }
                }

                $orig.val(email.slice(0, -1))

                  //console.log($orig.val());


            });

            $(document).on('click','.cancel-email',function(){
                $(this).parent().remove();
                 $('#clientEmail').val('');

                var x =[];
                $('.emailAddress').each(function(index, obj)
                {
                  x.push($(this).text());
                });
                //console.log( $('#clientEmail').val());

                $('#clientEmail').val(x)

                 //$orig.val('');
                 email= x;

                //console.log(x, $orig.val());

            });

            if(settings.data){
                $.each(settings.data, function (x, y) {
                    if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(y)){
                        $('.all-mail').append('<span class="email-ids">' + y + '<span class="cancel-email">x</span></span>');
                        $element.val('');

                        email += y + ','
                    } else {
                        $element.css('border', '1px solid red')
                    }
                })

                $orig.val(email.slice(0, -1))
            }


            return $orig.hide()
        });
    };

})(jQuery);

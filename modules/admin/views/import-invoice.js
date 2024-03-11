
$(document).ready(function() {

     $('#sagaButtons button').on('click', function(e){

        var type = $(this).parent().attr('data-type');
        var invoice = $(this).parent().attr('data-invoice');
        var code = $(this).parent().attr('data-code');
        var request = $(this).parent().attr('data-request');
        var notification = $(this).parent().attr('data-notification');
       


        console.log(type, invoice, code);

        switch($(this).attr('id')) {
          case 'generateSagaFormat':
            thisUrl = "/cron/startSagaImport?type="+type+"&invoice="+invoice+"&code="+code;
            break;
          case 'sendToSaga':
            thisUrl = "/cron/sendSagaRequests?request="+request+"&target=0269";
            break;
          case 'checkRequest':
            thisUrl = "/cron/checkSagaRequests?notificationId="+notification;
        }

        console.log(thisUrl);

            $.ajax({
                url: thisUrl,
           }).success(function(json){
            if(json>0) {
                $('.addUserError').addClass('hidden');
               location.reload()
            } else {
                $('.addUserError').removeClass('hidden');
            }
              
            }).error(function(xhr, status, error) {
               $('.addUserError').removeClass('hidden');
            })
        })
    
});
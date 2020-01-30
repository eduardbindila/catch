$(document).ready(function(){

Dropzone.autoDiscover = false;

$('#importPrices').on('submit', function(e){
            e.preventDefault();
console.log($(this).serializeArray());
            $.ajax({
                url: "/ajax/addDesigners",
                type: "post",
                dataType: "json",
                data: $(this).serializeArray()
           }).success(function(json){
               $('.importPricesSuccess').removeClass('hidden');
               $('#importPrices').addClass('hidden');

            }).error(function(xhr, status, error) {
                $('.importPricesError').removeClass('hidden');
            })
        })

});

$(function() {
    //Dropzone class
    var myDropzone = new Dropzone(".dropzone", {
        url: "/ajax/uploadFile",
        paramName: "file",
        maxFilesize: 2,
        maxFiles: 1,
        acceptedFiles: ".csv",
        autoProcessQueue: true,
        init: function () {
            this.on("success", function (file, response) {
                console.log("sucesso", response, file);
                $('#file-name').val(response.trim());
            });
        }
    });
});
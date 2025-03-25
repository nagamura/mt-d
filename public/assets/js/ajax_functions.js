$(function(){
    $('.downloadBtn').on('click', function(){
    var id =  $(this).attr("id");
        $.ajax({
                    url: 'api_test/downloads/' + id,
                    type: "POST",
                    // success: function(data) {alert(data.message)},
                    // error: function(data) {alert(data.message)}
        });
    })
});

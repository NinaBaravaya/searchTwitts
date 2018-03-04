$(function() {
    $("#get_results").on('submit',function(event) {
        event.preventDefault();
        var searchString = $("#search_box").val();
        if(searchString.search(/[^a-zA-Zа-яА-Я]/g)) {
            var data  = 'search='+ searchString;
            if(searchString) {
                $.ajax({
                    type: "GET",
                    url: "../index.php",
                    data: data,
                    success: function(d){
                        $("#results").html(d);
                    }
                });
            }
       }
        return false;
    });
});


$(document).on("click", ".add_twit", function (event) {
        $(this).css('color','red');
        event.preventDefault();
        var form = $(this).parent().css('color','red');
        var data = ($(form).serialize());
        if(data) {
            $.ajax({
                type: "POST",
                url: "../index.php",
                data: data,
                success: function(d){
                    $("#fromDB").append(d);
                }
            });
        }
});


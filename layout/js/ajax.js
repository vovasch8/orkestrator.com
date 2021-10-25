
$( "#dep-select" ).change(function() {
    $.ajax({
        type: "POST",
        url: "time-register-ajax",
        data: {dep : $("#dep-select").val(), sdate : $("#date-select").val()},
        success: function (html) {
            $("#content").html(html);
        }
    });

});

$( "#date-select" ).change(function() {
    $.ajax({
        type: "POST",
        url: "time-register-ajax",
        data: {dep : $("#dep-select").val(), sdate : $("#date-select").val()},
        success: function (html) {
            $("#content").html(html);
        }
    });

});

$( "#user-list-select" ).change(function() {
    $.ajax({
        type: "POST",
        url: "user-list-ajax",
        data: {dep : $("#user-list-select").val()},
        success: function (html) {
            $("#content").html(html);
        }
    });

});


    window.setInterval(function () {
            $.ajax({
                type: "POST",
                url: "kitchenAjax",
                success: function (html) {
                    $("#content").html(html);
                }
            });
    }, 3000);

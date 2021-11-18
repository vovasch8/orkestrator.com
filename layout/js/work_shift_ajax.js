
$("#left-week-triangle").click(function () {
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block: 'week-block', arrow : 'left'},
        success: function (html) {
            $("#week-blocks").html(html);
            date = $(".active-day").attr("id");
            updateBlocks(date);
        }
    })
});

$("#right-week-triangle").click(function () {
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block: 'week-block', arrow : 'right'},
        success: function (html) {
            $("#week-blocks").html(html);
            date = $(".active-day").attr("id");
            updateBlocks(date);
        }
    })

});

$(".day-block").click(function () {
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'day-block', day : this.id},
        success: function (html) {
            $("#cur_date").html(html);
            getDayShift();
            getNightShift();
            getAddDayMenu();
            getAddNightMenu();
            updateState();
        }
    });
});

function updateBlocks(date){
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'day-block', day : date},
        success: function (html) {
            $("#cur_date").html(html);
            getDayShift();
            getNightShift();
            getAddDayMenu();
            getAddNightMenu();
            updateState();
        }
    });
}

function getDayShift(){
    var date = $("#cur_date span").attr("date");
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'day-shift-block', date : date},
        success: function (html) {
            $("#day-shift").html(html);
        }
    });
}

function getNightShift(){
    var date = $("#cur_date span").attr("date");
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'night-shift-block', date : date},
        success: function (html) {
            $("#night-shift").html(html);
        }
    });
}

function getAddDayMenu(){
    var date = $("#cur_date span").attr("date");
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {menu: "menu", block : 'add-day-menu-block', date : date},
        success: function (html) {
            $("#DropdownDayAdd").html(html);
        }
    });
}

function getAddNightMenu(){
    var date = $("#cur_date span").attr("date");
    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {menu: "menu", block : 'add-night-menu-block', date : date},
        success: function (html) {
            $("#DropdownNightAdd").html(html);
        }
    });
}

function saveShifts(){
    $('#message span').remove();
    var nightShift = new Array();
    var dayShift = new Array();
    var date = $("#cur_date span").attr("date");
    var check = false;
    if(document.getElementById('save-week').checked){
        check = true;
    }

    $("#night-shift input[type='checkbox']").each(function() {
        var id = this.id.substr(6, this.id.length);
        nightShift.push(id);
    });

    $("#day-shift input[type='checkbox']").each(function() {
        var id = this.id.substr(6, this.id.length);
        dayShift.push(id);
    });

    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'save-block', day_shift : JSON.stringify(dayShift), night_shift: JSON.stringify(nightShift), date: date, check: check},
        success: function (html) {
            $("#message").html(html);
        }
    });
}

function updateState(){
    $('#message span').remove();
    var date = $('#cur_date span').attr('date');
    var cur_date = new Date();
    date = Date.parse(date + 'T18:00:00');
    if(date < cur_date){
         document.getElementById("day-menu").style.visibility = 'hidden';
         document.getElementById("night-menu").style.visibility = 'hidden';
         document.getElementById("save-block").style.visibility = 'hidden';
         document.getElementById("triangle-copy-left").style.visibility = 'hidden';
         document.getElementById("triangle-copy-right").style.visibility = 'hidden';
    }else{
        document.getElementById("day-menu").style.visibility = 'visible';
        document.getElementById("night-menu").style.visibility = 'visible';
        document.getElementById("save-block").style.visibility = 'visible';
        document.getElementById("triangle-copy-left").style.visibility = 'visible';
        document.getElementById("triangle-copy-right").style.visibility = 'visible';
    }
}

function transferToNextWeek(){
    var nightShift = new Array();
    var dayShift = new Array();
    var date = $("#cur_date span").attr("date");

    $("#night-shift input[type='checkbox']").each(function() {
        var id = this.id.substr(6, this.id.length);
        nightShift.push(id);
    });

    $("#day-shift input[type='checkbox']").each(function() {
        var id = this.id.substr(6, this.id.length);
        dayShift.push(id);
    });

    $.ajax({
        type: "POST",
        url: "work-shift-ajax",
        data: {block : 'transfer-block', day_shift : JSON.stringify(dayShift), night_shift: JSON.stringify(nightShift), date: date},
        success: function (html) {
            $("#message").html(html);
        }
    });
}
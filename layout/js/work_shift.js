//Menu +

function dropNightShift() {
    document.getElementById("DropdownNight").classList.toggle("show");
}

function dropDayShift(){
    document.getElementById("DropdownDay").classList.toggle("show");
}

function dropDayAdd(){
    document.getElementById("DropdownDayAdd").classList.toggle("show");
}

function dropNightAdd(){
    document.getElementById("DropdownNightAdd").classList.toggle("show");
}

function addUserDay(el){
    userId = $(el).attr("id");
    name = $(el).text();
    ul = document.getElementById('day-shift');
    ul.innerHTML += '<li id=li-'+ userId + '>\n' +
        '<input class="form-check-input day-check"  type="checkbox" id="nс-'+userId+'">\n' +
        '<label class="form-check-label" id="l-'+userId+'" for="nc-'+userId+'">'+name+'</label>\n' +
        '</li>';
    document.getElementById(userId).remove();
    document.getElementById('un-'+userId.substr(3, userId.length)).remove();
}

function addUserNight(el){
    userId = $(el).attr("id");
    name = $(el).text();
    ul = document.getElementById('night-shift');
    ul.innerHTML += '<li id=li-'+ userId + '>\n' +
        '<input class="form-check-input night-check" type="checkbox" id="nс-'+userId+'">\n' +
        '<label class="form-check-label" id="l-'+userId+'" for="nc-'+userId+'">'+name+'</label>\n' +
        '</li>';
    document.getElementById(userId).remove();
    document.getElementById('ud-'+userId.substr(3, userId.length)).remove();
}

//Menu -

function dayDel(){
    $("#day-shift input[type='checkbox']:checked").each(function(){
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));

        el1 = document.getElementById('DropdownDayAdd');
        el1.innerHTML += '<a onclick="addUserDay(this)" class="user-day" id="' + parentId.substr(3, parentId.length) + '">' + lab.textContent + '</a>';

        el2 = document.getElementById('DropdownNightAdd');
        el2.innerHTML += '<a onclick="addUserNight(this)" class="user-night" id="un-' + parentId.substr(6, parentId.length) + '">' + lab.textContent + '</a>';

        this.parentNode.remove();
    });
}

function nightDel(){
    $("#night-shift input[type='checkbox']:checked").each(function(){
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));

        el1 = document.getElementById('DropdownDayAdd');
        el1.innerHTML += '<a onclick="addUserDay(this)" class="user-day" id="ud-' + parentId.substr(6, parentId.length) + '">' + lab.textContent + '</a>';

        el2 = document.getElementById('DropdownNightAdd');
        el2.innerHTML += '<a onclick="addUserNight(this)" class="user-night" id="' + parentId.substr(3, parentId.length) + '">' + lab.textContent + '</a>';

        this.parentNode.remove();
    });
}

// Pointers <>

function copyToNightShift(){
    $("#day-shift input[type='checkbox']:checked").each(function() {
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));
        el = document.getElementById('night-shift');
        el.innerHTML += '<li id=li-un-' + this.id.substr(6, this.id.length) + '>\n' +
            '<input class="form-check-input night-check" type="checkbox" id="nс-un-' + this.id.substr(6, this.id.length) + '">\n' +
            '<label class="form-check-label" id="l-un-' + this.id.substr(6, this.id.length) + '" for="nc-un-' + this.id.substr(6, this.id.length) + '">' + lab.textContent + '</label>\n' +
            '</li>';
        this.parentNode.remove();
    });
}

function copyToDayShift(){
    $("#night-shift input[type='checkbox']:checked").each(function() {
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));
        el = document.getElementById('day-shift');
        el.innerHTML += '<li id=li-ud-' + this.id.substr(6, this.id.length) + '>\n' +
            '<input class="form-check-input night-check" type="checkbox" id="nс-ud-' + this.id.substr(6, this.id.length) + '">\n' +
            '<label class="form-check-label" id="l-ud-' + this.id.substr(6, this.id.length) + '" for="nc-ud-' + this.id.substr(6, this.id.length) + '">' + lab.textContent + '</label>\n' +
            '</li>';
        this.parentNode.remove();
    });
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

//Menu V

function checkAllDay() {
    $("#day-shift input[type='checkbox']").each(function() {
       this.checked = true;
    });
}

function checkAllNight() {
    $("#night-shift input[type='checkbox']").each(function() {
       this.checked = true;
    });
}

function changeShifts(){
    $("#day-shift input[type='checkbox']").each(function() {
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));
        el = document.getElementById('changer');
        el.innerHTML += '<li id=li-un-' + this.id.substr(6, this.id.length) + '>\n' +
            '<input class="form-check-input night-check" type="checkbox" id="nс-un-' + this.id.substr(6, this.id.length) + '">\n' +
            '<label class="form-check-label" id="l-un-' + this.id.substr(6, this.id.length) + '" for="nc-un-' + this.id.substr(6, this.id.length) + '">' + lab.textContent + '</label>\n' +
            '</li>';
        this.parentNode.remove();
    });
    $("#night-shift input[type='checkbox']").each(function() {
        var parentId = this.parentNode.id;

        lab = document.getElementById('l-' + parentId.substr(3, parentId.length));
        el = document.getElementById('day-shift');
        el.innerHTML += '<li id=li-ud-' + this.id.substr(6, this.id.length) + '>\n' +
            '<input class="form-check-input night-check" type="checkbox" id="nс-ud-' + this.id.substr(6, this.id.length) + '">\n' +
            '<label class="form-check-label" id="l-ud-' + this.id.substr(6, this.id.length) + '" for="nc-ud-' + this.id.substr(6, this.id.length) + '">' + lab.textContent + '</label>\n' +
            '</li>';
        this.parentNode.remove();
    });
    document.getElementById("night-shift").innerHTML = document.getElementById('changer').innerHTML;
    document.getElementById('changer').innerHTML = '';
}

const list = document.querySelectorAll('.day-block')
list.forEach(item =>{
    item.addEventListener('click', (e) =>{
        list.forEach(el=>{ el.classList.remove('active-day'); });
        item.classList.add('active-day');
    })
})

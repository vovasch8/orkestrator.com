function tab_login(){
    document.getElementById("login-form").style.display = "inline-block";
    document.getElementById("scan-form").style.display = "none";
    document.getElementById("link-scan").classList.remove("active-tab");
    document.getElementById("link-login").classList.add("active-tab");
}
function tab_scan(){
    document.getElementById("login-form").style.display = "none";
    document.getElementById("scan-form").style.display = "inline-block";
    document.getElementById("link-login").classList.remove("active-tab");
    document.getElementById("link-scan").classList.add("active-tab");
}

function tab_choice_stand(){
    document.getElementById("choice_stand").style.display = "inline-block";
    document.getElementById("scan_stand").style.display = "none";
    document.getElementById("link-scan-stand").classList.remove("active-tab");
    document.getElementById("link-choice-stand").classList.add("active-tab");
}
function tab_scan_stand(){
    document.getElementById("choice_stand").style.display = "none";
    document.getElementById("scan_stand").style.display = "inline-block";
    document.getElementById("link-choice-stand").classList.remove("active-tab");
    document.getElementById("link-scan-stand").classList.add("active-tab");
}
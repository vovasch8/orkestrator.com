var isClosed = true;

function openNav() {
    if(isClosed == true){
        document.getElementById("sidebar").style.display = "inline-block";
        document.getElementById("sidebar").style.visibility = "visible";
        document.getElementById("admin-content").style.paddingLeft = "310px";
        document.getElementById('openbtn').style.width = "305px";
        isClosed = false;
    }else{
        document.getElementById("sidebar").style.display = "none";
        document.getElementById("sidebar").style.visibility = "hidden";
        document.getElementById("admin-content").style.paddingLeft = "0px";
        document.getElementById('openbtn').style.width = "50px";
        isClosed = true;
    }
}
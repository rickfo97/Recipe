/**
 * Created by Rickardh on 2016-05-13.
 */
function loadURL(url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(xhttp.readyState == 3 || xhttp.readyState == 2 || xhttp.readyState == 1){
            document.getElementById("content").innerHTML = '<img src="/img/loading.gif">';
        }
        if(xhttp.readyState == 4 && xhttp.status == 200){
            document.getElementById("content").innerHTML = xhttp.responseText;
            document.title = xhttp.pageTitle;
            window.history.pushState({"html":xhttp.html,"pageTitle":xhttp.pageTitle},"", url);
        }else if(xhttp.readyState == 4 && xhttp.status == 404){
            document.getElementById("content").innerHTML = "<h1 class='text-center'>404 not found</h1>";
            document.title = xhttp.pageTitle;
            window.history.pushState({"html":xhttp.responseText,"pageTitle":xhttp.pageTitle},"", url);
        }
    };
    xhttp.open("GET", url + "?ajax=true, true");
    xhttp.send();
};

function changeTitle(title) {
    document.title = title;
}
window.onpopstate = function (e) {
    if(e.state){
        document.getElementById("content").innerHTML = e.state.html;
        document.title = e.state.pageTitle;
    }
}
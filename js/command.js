function sendComm(comm) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "exec.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        var DONE = 4;
        var OK = 200;
        if (xhr.readyState == DONE) {
            console.log("sent " + comm);
        }
        //console.log(xhr.responseText);
    };
    var senddata = 'command='+comm;
    xhr.send(senddata);
}
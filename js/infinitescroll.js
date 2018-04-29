var off = 1;
var send = true;
var file;
var formdata = false;
var data;
//below taken from http://www.howtocreate.co.uk/tutorials/javascript/browserwindow
function getScrollXY() {
    var scrOfX = 0, scrOfY = 0;
    if( typeof( window.pageYOffset ) == 'number' ) {
        //Netscape compliant
        scrOfY = window.pageYOffset;
        scrOfX = window.pageXOffset;
    } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
        //DOM compliant
        scrOfY = document.body.scrollTop;
        scrOfX = document.body.scrollLeft;
    } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
        //IE6 standards compliant mode
        scrOfY = document.documentElement.scrollTop;
        scrOfX = document.documentElement.scrollLeft;
    }
    return [ scrOfX, scrOfY ];
}

//taken from http://james.padolsey.com/javascript/get-document-height-cross-browser/
function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );
}

function load() {
    document.addEventListener("scroll", function (event) {
        if (getDocHeight() <= getScrollXY()[1] + window.innerHeight +200 && send) {
            send = false;
            loadAds();
        }
    });
}

function loadAds() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', file, true);
    if(!formdata)
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        var DONE = 4;
        var OK = 200;
        if (xhr.readyState == DONE) {
            document.getElementById('loading-div').style.display = "none";
            document.getElementById("adspace").innerHTML += xhr.responseText;

            if(xhr.responseText.length > 0) {
                off++;
                send = true;
                console.log("off rec" + off);
                if (typeof adsLoaded == "function") {
                    adsLoaded();
                }
            }
        }
        //console.log(xhr.responseText);
    }
    var senddata;
    if(formdata) {
        data.set("offset", off);
        senddata = data;
    }else{
        senddata = 'offset='+off;
    }
    xhr.send(senddata);
    document.getElementById('loading-div').style.display = "block";
    console.log("off send" + off);
}
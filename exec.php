<?php
$com = $_POST['command'];
switch($com){
    case "skip":
        echo exec('wscript "keys.vbs" "s"');
        break;
    case "play":
        echo exec('wscript "keys.vbs" "{ENTER}"');
        break;
    case "rewind":
        echo exec('wscript "keys.vbs" "{LEFT}"');
        break;
    case "forward":
        echo exec('wscript "keys.vbs" "{RIGHT}"');
        break;
    case "min":
        echo exec('wscript "keys.vbs" "{ESC}"');
        break;
    case "full":
        echo exec('wscript "keys.vbs" "f"');
        break;

}

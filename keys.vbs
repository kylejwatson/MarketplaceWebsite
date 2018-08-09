Set WshShell = WScript.CreateObject("WScript.Shell")
WshShell.AppActivate "chrome"
WshShell.SendKeys WScript.Arguments(0)
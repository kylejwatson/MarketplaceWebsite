<?php
$view = new stdClass();
$view->pageTitle = 'Calculator';
require_once('Models/Calculator.php');
if(isset($_POST['submit']))
{
    $calc = new Calculator($_POST['number1'],$_POST['number2'],$_POST['operation']);
    $value = $calc->calculate();
    if(!$value){
        $view->result = "Not a valid number";
        $view->error = "danger";
        $view->glyph = "exclamation-sign";
    }else {
        $view->result = $_POST['number1'] . $_POST['operation'] . $_POST['number2'] . '=' . $value;
        if($value == "error"){
            $view->error = "info";
            $view->glyph = "question-sign";
            $view->result = $_POST['operation'] . " is not an operation";
        }else {
            $view->error = "success";
            $view->glyph = "ok-sign";
        }
    }
}
require_once('Views/calculator.phtml');

<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 24/10/17
 * Time: 12:53
 */

class Calculator
{
    var $number1 = 0, $number2 = 0, $opr = '';
    public function __construct($number1, $number2, $opr) {
        $this->number1 = $number1;
        $this->number2 = $number2;
        $this->opr = $opr;
    }
    public function calculate()
    {
        if (is_numeric($this->number1) && is_numeric($this->number2)) {
            if ($this->opr == '+') {
                $result = $this->number1 + $this->number2;
            } elseif ($this->opr == '-') {
                $result = $this->number1 - $this->number2;
            } elseif ($this->opr == '*') {
                $result = $this->number1 * $this->number2;
            } elseif ($this->opr == '/') {
                $result = $this->number1 / $this->number2;
            } else {
                $result = 'error';
            }
        }else {
            $result = false;
        }
        return $result;
    }
}
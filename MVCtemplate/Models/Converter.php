<?php
/**
 * Created by PhpStorm.
 * User: stc905
 * Date: 24/10/17
 * Time: 12:53
 */

class Converter
{
    var $number = 0, $unit = '';
    public function __construct($number, $unit) {
        $this->number = $number;
        $this->unit = $unit;
    }
    public function convert()
    {
        if (is_numeric($this->number)) {
            if ($this->unit == 'miles to km') {
                $result = $this->number * 1.609;
            } elseif ($this->unit == 'km to miles') {
                $result = $this->number * 0.621;
            } else {
                $result = 'error';
            }
        }else {
            $result = false;
        }
        return $result;
    }
}
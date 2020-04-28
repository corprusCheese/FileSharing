<?php

namespace app\other;

//дает информацию об используемой бд
class DbHelper
{
    public static function getDbName($name,$dsn){
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}
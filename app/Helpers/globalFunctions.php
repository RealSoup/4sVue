<?php
//  쿼리 출력
if (! function_exists('echo_query')) {
    function echo_query($obj) {
        dd(array_reduce($obj->getBindings(), function($sql, $binding){
            return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
        }, $obj->toSql()));
    }
}

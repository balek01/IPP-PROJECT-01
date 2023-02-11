<?php

$array = [];
function array_push_var()
{
    global $array;
    array_push($array, "var");
}

function array_push_symbol($ln)
{global $array;
    foreach (array_slice($ln,1) as $a){
        //$type=get_type();
        array_push($array, "var");
    }
}



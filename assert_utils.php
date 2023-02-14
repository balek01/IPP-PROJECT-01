<?php

const ARI = 3;
const COMP = 3;
const LOG = 3;
const NOT = 2;
const I2CH = 2;
const S2I = 3;
const OVAR = 1;
const OLAB = 1;
const OSYM = 1;
const ZERO = 0;
const MOVE = 2;
const READ = 2;
const CON = 3;
const SLEN = 3;
const GCHAR = 3;
const EX = 1;
const CALL = 2;

const ANY = 1;
const INT = 2;
const BOOL = 3;
const STR = 4;
const LABEL = 5;


function assert_arithmetic($ln)
{
    assert_arg_count($ln, ARI);
    assert_variable($ln);
    assert_symbol($ln, 2, /*INT*/);
}

function assert_compare($ln)
{
    assert_arg_count($ln, COMP);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_logical($ln)
{
    assert_arg_count($ln, LOG);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_not($ln)
{
    assert_arg_count($ln, NOT);
    assert_variable($ln);
    assert_symbol($ln);
}

function assert_i2ch($ln)
{
    assert_arg_count($ln, I2CH);
    assert_variable($ln);
    assert_symbol($ln, 1/*, INT*/);
}
function assert_s2i_gchar($ln)
{
    assert_arg_count($ln, S2I);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_schar($ln)
{
    assert_arg_count($ln, GCHAR);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_exit($ln)
{
    assert_arg_count($ln, EX);
    assert_symbol($ln, 1, ANY, 1);
}

function assert_only_var($ln)
{
    assert_arg_count($ln, OVAR);
    assert_variable($ln);
}

function assert_only_sym($ln)
{
    assert_arg_count($ln, OSYM);
    assert_symbol($ln, 1, ANY, 1);
}

function assert_no_args($ln)
{
    assert_arg_count($ln, ZERO);
}

function assert_move($ln)
{
    assert_arg_count($ln, MOVE);
    assert_variable($ln);
    assert_symbol($ln, 1);
}

function assert_read($ln)
{
    assert_arg_count($ln, READ);
    assert_variable($ln);
    assert_type($ln);
}

function assert_concat($ln)
{
    assert_arg_count($ln, CON);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function  assert_type_slen($ln)
{
    assert_arg_count($ln, SLEN);
    assert_variable($ln);
    assert_symbol($ln, 1);
}

function assert_jumpif($ln)
{
    assert_arg_count($ln, SLEN);
    assert_label($ln);
    assert_symbol($ln, 2);
}

function assert_type($ln, $offset = 2)
{

    if (!preg_match('/(^int$)|(^string$)|(^bool$)/', $ln[$offset])) {
        exit(EXIT_LEXSYN);
    }
}

function assert_arg_count($ln, $expected)
{
    if ($expected != (sizeof($ln) - 1)) {
        exit(EXIT_LEXSYN);
    }
}

function assert_variable($ln)
{
    $var = $ln[1];
    //variable regex ((LF|GF|TF)@{anything but number}{anything} 
    if (!preg_match('/^((LF|GF|TF)@(([_\-$&;%*!?]|[A-Z]|[a-z]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]))+([_\-$&%*!?]|[A-Z]|[a-z]|[0-9]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ])*)$/', $var)) {
        exit(EXIT_LEXSYN);
    }
}

function assert_symbol($ln, $count = 1, $type = ANY, $offset = 2)
{
    //get only symbols from line
    $symbols = array_slice($ln, $offset, $offset + $count);
    $regex = get_regex($type);

    for ($i = 0; $i < $count; $i++) {

        if (!preg_match($regex, $symbols[$i])) {
            exit(EXIT_LEXSYN);
        }
    }
}
function assert_only_label($ln)
{
    assert_arg_count($ln, OLAB);
    assert_label($ln);
}


function assert_label($ln, $count = 1)
{
    $offset = 1;

    $regex = get_regex(LABEL);
    for ($i = $offset; $i <= $count; $i++) {
        if (!preg_match($regex, $ln[$offset])) {
            exit(EXIT_LEXSYN);
        }
    }
}

function get_regex($type)
{
    //variable regex ((LF|GF|TF)@{anything but number}{anything} 
    $varreg = '^((LF|GF|TF)@(([_\-;$&%*!?]|[A-Z]|[a-z]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]))+([_\-$&%*!?]|[A-Z]|[a-z]|[0-9]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ])*)$';
    $intreg = '(^(int@[-|+]?[0-9]+)$)';
    $boolreg = '(^(bool@false|bool@true)$)';
    $labelreg = '^([_\-$&%*!?]|[A-Z]|[a-z]|[0-9])+$';
    $strreg = '(^string@(?:[^\\\\]|\\\\\\d{3})*$)';
    switch ($type) {
        case ANY:
            $regex = '/' . $varreg . '|(^nil@nil$)|' . $intreg . '|' . $boolreg . '|' . $strreg . '/';
            break;
        case INT:
            $regex = '/' . $intreg . '|' . $varreg . '/';
            break;
        case BOOL:
            $regex = '/' . $boolreg . '|' . $varreg . '/';
            break;
        case STR:
            $regex = '/' . $strreg . '|' . $varreg . '/';
            break;
        case LABEL:
            $regex = '/' . $labelreg . '/';
            break;
        default:
            exit(EXIT_INTERNAL_ERROR);
            break;
    }

    return $regex;
}

function assert_header($ln)
{
    global $header;
    if ($ln != '.IPPcode23')  exit(EXIT_HEADER);
    $header = true;
    return $header;
}

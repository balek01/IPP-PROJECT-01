<?php


abstract class Arg_Count
{
    const
        ZERO = 0,
        EX = 1,
        OVAR = 1,
        OLAB = 1,
        OSYM = 1,
        NOT = 2,
        CALL = 2,
        I2CH = 2,
        MOVE = 2,
        READ = 2,
        ARI  = 3,
        COMP = 3,
        LOG = 3,
        S2I = 3,
        CON = 3,
        SLEN = 3,
        GCHAR = 3,
        SCHAR = 3;
}

abstract class Arg_Type
{
    const
        ANY = 1,
        INT = 2,
        BOOL = 3,
        STR = 4,
        LABEL = 5;
}

function assert_arithmetic($ln)
{
    assert_arg_count($ln, Arg_Count::ARI);
    assert_variable($ln);
    assert_symbol($ln, 2, /*INT*/);
}

function assert_compare($ln)
{
    assert_arg_count($ln, Arg_Count::COMP);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_logical($ln)
{
    assert_arg_count($ln, Arg_Count::LOG);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_not($ln)
{
    assert_arg_count($ln, Arg_Count::NOT);
    assert_variable($ln);
    assert_symbol($ln);
}

function assert_i2ch($ln)
{
    assert_arg_count($ln, Arg_Count::I2CH);
    assert_variable($ln);
    assert_symbol($ln, 1/*, INT*/);
}
function assert_s2i_gchar($ln)
{
    assert_arg_count($ln, Arg_Count::S2I);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_schar($ln)
{
    assert_arg_count($ln, Arg_Count::SCHAR);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function assert_exit($ln)
{
    assert_arg_count($ln, Arg_Count::EX);
    assert_symbol($ln, 1, Arg_Type::ANY, 1);
}

function assert_only_var($ln)
{
    assert_arg_count($ln, Arg_Count::OVAR);
    assert_variable($ln);
}

function assert_only_sym($ln)
{
    assert_arg_count($ln, Arg_Count::OSYM);
    assert_symbol($ln, 1, Arg_Type::ANY, 1);
}

function assert_no_args($ln)
{
    assert_arg_count($ln, Arg_Count::ZERO);
}

function assert_move($ln)
{
    
    assert_arg_count($ln, Arg_Count::MOVE);
    assert_variable($ln);
    assert_symbol($ln, 1);
}

function assert_read($ln)
{
    assert_arg_count($ln, Arg_Count::READ);
    assert_variable($ln);
    assert_type($ln);
}

function assert_concat($ln)
{
    assert_arg_count($ln, Arg_Count::CON);
    assert_variable($ln);
    assert_symbol($ln, 2);
}

function  assert_type_slen($ln)
{
    assert_arg_count($ln, Arg_Count::SLEN);
    assert_variable($ln);
    assert_symbol($ln, 1);
}

function assert_jumpif($ln)
{
    assert_arg_count($ln, Arg_Count::SLEN);
    assert_label($ln);
    assert_symbol($ln, 2);
}

function assert_type($ln, $offset = 2)
{

    if (!preg_match('/(^int$)|(^string$)|(^bool$)/', $ln[$offset])) {
        exit(Exit_Code::LEXSYN);
    }
}

function assert_arg_count($ln, $expected)
{
    if ($expected != (sizeof($ln) - 1)) {
        exit(Exit_Code::LEXSYN);
    }
}

function assert_variable($ln)
{
    $var = $ln[1];
    //variable regex ((LF|GF|TF)@{anything but number}{anything} 
    if (!preg_match('/^((LF|GF|TF)@(([_\-$&;%*!?]|[A-Z]|[a-z]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]))+([_\-$&%*!?]|[A-Z]|[a-z]|[0-9]|[áčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ])*)$/', $var)) {
        exit(Exit_Code::LEXSYN);
    }
}

function assert_symbol($ln, $count = 1, $type = Arg_Type::ANY, $offset = 2)
{
    //get only symbols from line
    $symbols = array_slice($ln, $offset, $offset + $count);
    $regex = get_regex($type);

    for ($i = 0; $i < $count; $i++) {

        if (!preg_match($regex, $symbols[$i])) {
            exit(Exit_Code::LEXSYN);
        }
    }
}
function assert_only_label($ln)
{
    assert_arg_count($ln, Arg_Count::OLAB);
    assert_label($ln);
}


function assert_label($ln, $count = 1)
{
    $offset = 1;

    $regex = get_regex(Arg_Type::LABEL);
    for ($i = $offset; $i <= $count; $i++) {
        if (!preg_match($regex, $ln[$offset])) {
            exit(Exit_Code::LEXSYN);
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
        case Arg_Type::ANY:
            $regex = '/' . $varreg . '|(^nil@nil$)|' . $intreg . '|' . $boolreg . '|' . $strreg . '/';
            break;
        case Arg_Type::INT:
            $regex = '/' . $intreg . '|' . $varreg . '/';
            break;
        case Arg_Type::BOOL:
            $regex = '/' . $boolreg . '|' . $varreg . '/';
            break;
        case Arg_Type::STR:
            $regex = '/' . $strreg . '|' . $varreg . '/';
            break;
        case Arg_Type::LABEL:
            $regex = '/' . $labelreg . '/';
            break;
        default:
            exit(Exit_Code::INTERNAL_ERROR);
            break;
    }

    return $regex;
}

function assert_header($ln)
{
    global $header;
    if ($ln != '.IPPcode23')  exit(Exit_Code::HEADER);
    $header = true;
    return $header;
}

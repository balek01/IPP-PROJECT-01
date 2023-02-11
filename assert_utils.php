<?php

const ARI = 3;
const COMP = 3;
const LOG = 3;
const I2CH = 2;
const S2I = 3;
const OVAR = 1;
const ZERO = 0;
const MOVE = 2;

const ANY = 1;
const INT = 2;
const BOOL = 3;
const STR = 4;
const LABEL = 5;



function assert_arithmetic($ln)
{
    assert_arg_count($ln, ARI);
    assert_variable($ln);
    assert_symbol($ln, 2, INT);
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
    assert_arg_count($ln, LOG);
    assert_variable($ln);
    assert_symbol($ln);
}

function assert_i2ch($ln)
{
    assert_arg_count($ln, I2CH);
    assert_variable($ln);
    assert_symbol($ln, 1, INT);
}
function assert_s2i($ln)
{
    assert_arg_count($ln, S2I);
    assert_variable($ln);
    assert_symbol($ln[2], 1, STR);
    assert_symbol($ln[3], 1, INT);
}

function assert_only_var($ln)
{
    assert_arg_count($ln, OVAR);
    assert_variable($ln);
}

function assert_no_args($ln)
{
    assert_arg_count($ln, ZERO);
}

function assert_move($ln)
{
    assert_arg_count($ln, 2);
    assert_variable($ln);
    assert_symbol($ln, 1, BOOL);
}


function assert_arg_count($ln, $expected)
{
    if ($expected != (sizeof($ln) - 1)) {
        //TODO: correct code

        exit(23);
    }
}
function assert_variable($ln)
{
    $var = $ln[1];

    //TODO: part after @
    if (!preg_match('/^((LF|GF|TF)@([_\-$&%*!?]|[A-Z]|[a-z]|[0-9])+)$/', $var)) {
        //TODO: correct code
        exit(23);
    }
}



function assert_symbol($ln, $count = 1, $type = ANY)
{
    $offset = 2;
    $symbols = array_slice($ln, $offset, $offset + $count);
    $regex = get_regex($type);

    for ($i = 0; $i < $count; $i++) {
        if (!preg_match($regex, $symbols[$i])) {
            //TODO: correct code
            exit(23);
        }
    }
}

function assert_label($ln)
{
    $offset = 1;

    $regex = get_regex(LABEL);
    if (!preg_match($regex, $ln[$offset])) {
        //TODO: correct code
        exit(23);
    }
}
function get_regex($type)
{
    $varreg = '^((LF|GF|TF)@([_\-$&%*!?]|[A-Z]|[a-z]|[0-9])+)$';
    switch ($type) {
        case ANY:
            $regex = '/^(LF|GF|TF|int|string|bool|nil)@([_\-$&%*!?]|[A-Z]|[a-z]|[0-9])+$/';
            break;
        case INT:
            $regex = '/^(int@[0-9]+)$|' . $varreg . '/';
            break;
        case BOOL:
            $regex = '/^(bool@false|bool@true)$|' . $varreg . '/';
            break;
        case STR:
            //TODO: check first part of regex
            $regex = '/^(str@.*)$|' . $varreg . '/';
            break;
        case LABEL:
            $regex = '/^([_\-$&%*!?]|[A-Z]|[a-z]|[0-9])+$/';
            break;
        default:
            # code...
            break;
    }
    return $regex;
}

function assert_header($ln)
{
    if ($ln != '.IPPcode23') {
        //TODO: error code
        exit(21);
    }

    return true;
}

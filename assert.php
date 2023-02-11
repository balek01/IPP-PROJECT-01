<?php
include "assert_utils.php";
include "get_array.php";
$order = 1;
function assertion($ln)
{
    global $order;
    $ln = explode(' ', $ln);
    $scope = "TODO";
    $opcode = strtoupper($ln[0]);



    switch ($opcode) {
        case 'ADD':
        case 'SUB':
        case 'MUL':
        case 'IDIV':
            assert_arithmetic($ln);

            array_push_var();
            array_push_symbol($ln);
            break;
        case 'LT':
        case 'GT':
        case 'EQ':
            assert_compare($ln);
            break;
        case 'AND':
        case 'OR':
            assert_logical($ln);
            break;
        case 'NOT':
            assert_not($ln);
            break;
        case 'INT2CHAR':
            assert_i2ch($ln);
            break;
        case 'STR2INT':
            assert_s2i($ln);
            break;
        case 'MOVE':
            assert_move($ln);
            break;
        case 'POPS':
        case 'DEFVAR':
            assert_only_var($ln);
            break;
        case 'CREATEFRAME':
        case 'PUSHFRAME':
        case 'POPFRAME':
        case 'RETURN':
            assert_no_args($ln);
            break;

        case 'PUSHS':
            //
            break;

        case 'JUMP':
        case 'CALL':
        case 'LABEL':
            assert_label($ln);
            break;
        case 'READ':
            //
            break;
        case 'WRITE':
            //
            break;
        case 'STRLEN':
            break;
        case 'CONCAT':
        case 'GETCHAR':
        case 'SETCHAR':
            break;
        case 'TYPE':
            break;

        case 'JUMPIFEQ':
            break;
        case 'JUMPNEQ':
            break;
        case 'EXIT':
            break;
        case 'DPRINT':
            break;
        case 'BREAK':
            break;

        default:
            //TODO: correct code
            exit(22);
            break;
    }

    /*
    $array =  array(
        $order,
        $scope,
        $opcode => array(
                $type => $value
    
        )
    );
    $order++;*/
    return $ln;
}

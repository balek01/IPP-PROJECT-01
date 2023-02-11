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
            //TODO: assert same type
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
        case 'GETCHAR':
            assert_s2i_gchar($ln);
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
        case 'BREAK':
            assert_no_args($ln);
            break;
        case 'WRITE':
        case 'DPRINT':
        case 'PUSHS':
            assert_only_sym($ln);
            break;

        case 'JUMP':
        case 'CALL':
        case 'LABEL':
            assert_label($ln);
            break;
        case 'READ':
            assert_read($ln);
            break;

        case 'STRLEN':
            break;
        case 'CONCAT':
            assert_concat($ln);
            break;
        case 'SETCHAR':
            assert_schar($ln);
            break;
        case 'TYPE':
            break;

        case 'JUMPIFEQ':
            break;
        case 'JUMPNEQ':
            break;
        case 'EXIT':
            assert_exit($ln);
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

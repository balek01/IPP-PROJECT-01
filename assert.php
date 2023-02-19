<?php
include "assert_utils.php";

function assertion(&$ln)
{
   
    $ln[0] = strtoupper($ln[0]);
    $opcode = $ln[0];
    switch ($opcode) {
        case 'ADD':
        case 'SUB':
        case 'MUL':
        case 'IDIV':
            assert_arithmetic($ln);
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
        case 'TYPE':
        case 'STRLEN':
            assert_i2ch($ln);
            break;
        case 'STRI2INT':
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
            assert_only_label($ln);
            break;
        case 'READ':
            assert_read($ln);
            break;
        case 'CONCAT':
            assert_concat($ln);
            break;
        case 'SETCHAR':
            assert_schar($ln);
            break;
        case 'JUMPIFEQ':
        case 'JUMPIFNEQ':
            assert_jumpif($ln);
            break;
        case 'EXIT':
            assert_exit($ln);
            break;
        default:
            exit(Exit_Code::OPCODE);
            break;
    }

    return $ln;
}

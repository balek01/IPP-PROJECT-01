<?php
include 'xmlcreator.php';
include 'assert.php';
include 'parse_utils.php';
include 'check_parameters.php';

abstract class Exit_Code
{
    const 
        OK = 0,
        HEADER = 21,
        OPCODE = 22,
        LEXSYN = 23,
        PARAM = 23,
        INTERNAL_ERROR = 99;
}

ini_set('display_errors', 'stderr');
check_parameters($argv);

$header = false;

while ($ln = fgets(STDIN)) {

    cultivate_input($ln);

    // skip empty lines
    if ($ln == '')  continue;

    if ($header === false) {
        assert_header($ln);
        continue;
    }

    $ln = explode(' ', $ln);
    cultivate_string($ln);
    assertion($ln);
    create_xml_tag($xml, $ln, $order);
}

print_xml($xml);
exit(Exit_Code::OK);

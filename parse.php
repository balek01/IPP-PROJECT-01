<?php
include 'xmlcreator.php';
include 'assert.php';
include 'parse_utils.php';

ini_set('display_errors', 'stderr');

const EXIT_OPCODE = 22;
const EXIT_HEADER = 21;
const EXIT_LEXSYN = 23;
const EXIT_INTERNAL_ERROR = 99;

// TODO no input
if (sizeof($argv) > 1) {
    ($argv[1] === "--help") ? print_help() : exit(10);
}
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
exit(0);

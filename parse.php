<?php
include 'xmlcreator.php';
include 'assert.php';

ini_set('display_errors', 'stderr');
//TODO: HELP
const EXIT_OPCODE = 22;
const EXIT_HEADER = 21;
const EXIT_LEXSYN = 23;
$header = false;

while ($ln = fgets(STDIN)) {

    $ln = cultivate_input($ln);

    // skip empty lines
    if ($ln == '') {
        continue;
    }
    if ($header === false) {
        $header = assert_header($ln);
        continue;
    }
    $ln = explode(' ', $ln);
    $ln = cultivate_string($ln);
    $ln = assertion($ln);
    $type_array = [];

    create_xml_tag($xml, $ln, $order);
}

print_($xml);
exit(0);

//todo: rename 
function cultivate_input($ln)
{
    if (str_contains($ln, "#")) {
        $ln = substr($ln, 0, strpos($ln, "#"));
    }

    $ln = preg_replace('/\s+/', ' ', $ln);
    $ln = trim($ln);
    return $ln;
}

function cultivate_string($ln)
{
    for ($i = 0; $i < sizeof($ln); $i++) {

        $ln[$i] = str_replace('<', '&lt;', $ln[$i]);
        $ln[$i] =  str_replace('>', '&gt;', $ln[$i]);
        if (!preg_match('/^(string@.*)$/', $ln[$i])) {
            $ln[$i] =  str_replace('&', '&amp;', $ln[$i]);
        }
    }
    return $ln;
}

function print_($xml)
{
    $xml = $xml->saveXML();
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml);
    echo ($dom->saveXML());
}

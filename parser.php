<?php
include 'xmlcreator.php';
include 'assert.php';

ini_set('display_errors', 'stderr');

$header = false;

while ($ln = fgets(STDIN)) {


    $ln = remove_comment($ln);
   
    // skip empty lines
    if ($ln == '') {
        continue;
    }
    //TODO: multiple headers
    if ($header===false) {
        $header = assert_header($ln);
        continue;
    }
    

  
    $ln = assertion($ln);
    $type_array =[];
   
    create_xml_tag($xml, $ln, $order);
}

print_($xml);




//todo: rename 
function remove_comment($ln)
{
    $ln = preg_replace('/[#].*[\n]/', '', $ln);
    $ln = preg_replace('/\s+/', ' ', $ln);
    $ln = trim($ln);
    return $ln;
}

function print_($xml)
{
    echo $xml->asXML();
}

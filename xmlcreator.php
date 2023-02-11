<?php

$xml = new SimpleXMLElement("<program language='IPPcode23'></program>");
$order = 1;

function create_xml_tag($xml, $ln)
{
    
    global $order;

    // Header('version="1.0" encoding="UTF-8"');
    $instruction = $xml->addChild('instruction');
    $instruction->addAttribute('order', $order);
    $instruction->addAttribute('opcode', $ln[0]);

    for ($i = 1; $i < sizeof($ln); $i++) {

        if (str_contains($ln[$i], "@")) {
            $value = substr(strstr($ln[$i], '@'),1);
            $arg = $instruction->addChild('arg' . $i, $value);
        } else {
            $arg = $instruction->addChild('arg' . $i, $ln[$i]);
        }

        $type = strstr($ln[$i], '@', true);
        $arg->addAttribute('type', $type);
    }

    $order++;
}

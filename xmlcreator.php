<?php

$xml= new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><program language="IPPcode23"></program>');

$order = 1;

function create_xml_tag($xml, $ln)
{

    global $order;

    $instruction = $xml->addChild('instruction');
    $instruction->addAttribute('order', $order);
    $instruction->addAttribute('opcode', $ln[0]);

    for ($i = 1; $i < sizeof($ln); $i++) {

        if (str_contains($ln[$i], "@")) {
            //var 
            if (preg_match('/^(LF|GF|TF)@([_\-$&%;*!?]|[A-Z]|[a-z]|[0-9])+$/', $ln[$i])) {
                $arg = $instruction->addChild('arg' . $i, $ln[$i]);
                $arg->addAttribute('type', 'var');
            } else {
                // constant
                $value = substr(strstr($ln[$i], '@'), 1);
                $arg = $instruction->addChild('arg' . $i, $value);
                $type = strstr($ln[$i], '@', true);
                $arg->addAttribute('type', $type);
            }
        } else {
            // if read expect type
            if ($ln[0]=="READ") {
                $arg = $instruction->addChild('arg' . $i, $ln[$i]);
                $arg->addAttribute('type', 'type');
            }else {
                //label 
                $arg = $instruction->addChild('arg' . $i, $ln[$i]);
                $arg->addAttribute('type', 'label');
            }

        }
    }

    $order++;
}

function print_xml($xml)
{
    /*
    $xml = $xml->saveXML();
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml);*/
    echo ($xml->saveXML());
}
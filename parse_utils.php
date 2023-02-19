<?php

function cultivate_input(&$ln)
{
    if (str_contains($ln, "#")) {
        $ln = substr($ln, 0, strpos($ln, "#"));
    }

    $ln = preg_replace('/\s+/', ' ', $ln);
    $ln = trim($ln);
    return $ln;
}

function cultivate_string(&$ln)
{
   
    for ($i = 0; $i < sizeof($ln); $i++) {

        //replace problematic characters
        $ln[$i] = str_replace('<', '&lt;', $ln[$i]);
        $ln[$i] =  str_replace('>', '&gt;', $ln[$i]);
        if (!preg_match('/^(string@.*)$/', $ln[$i])) {
            $ln[$i] =  str_replace('&', '&amp;', $ln[$i]);
        }
    }

}
function print_help()
{
    echo ("Použití: parse.php [VSTUP] [PARAMETR] \n");
    echo("PHP skript parse.php načítá IPPcode2023 z standartního vstupu, a provede základní lexikální a syntaktická analýzu.\n\n");
    echo("Korektní kód je vypsán na standartní výstup v XML reprezentaci.\n");
    echo("V případě nalezení chyby ve vstupním programu je skript ukončen s kódem 23.\n");
    echo("--help \t vypíše na standartní výstup nápovědu \n");
    exit(Exit_Code::OK);
}

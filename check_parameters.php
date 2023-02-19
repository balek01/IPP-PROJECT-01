<?php

function check_parameters ($argv)
{
    //if (sizeof($argv) == 1)  exit(Exit_Code::OK);

    if (sizeof($argv) > 1) {
    
        if (sizeof($argv) > 2) exit(Exit_Code::PARAM);
        if ($argv[1] === "--help") {
            print_help();
        } else {
            exit(Exit_Code::PARAM);
        }
    }
}
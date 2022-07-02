<?php

require("functions.php");
system("clear");

$inFix = "78.32*((0.36/63*(14-1000)*3.2222)*((0.36/63*(14-1000)*3.2222)*((0.36/63*(14-1000)*3.2222)*((0.36/63*(14-1000)*3.2222)))))";
echo("expression = ".$inFix.PHP_EOL);
echo("result  expected: ".eval("return ".$inFix.";").PHP_EOL);
echo("result evaluated: ".eval_expression($inFix).PHP_EOL);


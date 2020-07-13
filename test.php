<?php

require "src/Differ/Differ.php";

$diff = \Differ\Differ\genDiff("before.json", "after.json");
print_r($diff);

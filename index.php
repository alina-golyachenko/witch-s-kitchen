<?php

require "vendor/autoload.php";
include "Config/config.php";

$core = \Core\Core::getInstance();

$core -> init();
$core -> run();

$core -> done();


?>
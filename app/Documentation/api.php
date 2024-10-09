<?php
require("../../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan(["../../app/Controllers"]);
header('Content-Type: application/json');
echo $openapi->toJSON();
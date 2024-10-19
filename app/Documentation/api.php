<?php
require("../../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([
    "../../app/Controllers",
    "../../app/Controllers/Docs/UserDocumentation.php"
]);

header('Content-Type: application/json');
echo $openapi->toJSON();
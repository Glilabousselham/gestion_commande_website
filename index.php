<?php

use App\Boot\Application;

require_once "vendor/autoload.php";
require_once "config/config.php";
require_once "routes/web.php";
require_once "routes/api.php";


$app = new Application();

$app->run();

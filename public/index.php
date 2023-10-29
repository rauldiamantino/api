<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../app/Routes/Routes.php';
require_once '../app/config/config.php';
require_once '../app/Controllers/PrayersController.php';
require_once '../app/Utils/Validator.php';
require_once '../app/Utils/Authenticator.php';

Routes::defineRoutes();
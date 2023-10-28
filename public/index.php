<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../app/Routes/Routes.php';
require_once '../app/config/config.php';
require_once '../app/Controllers/PrayersController.php';
require_once '../app/Validations/Validator.php';

Routes::defineRoutes();
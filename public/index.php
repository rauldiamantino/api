<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../Routes/Routes.php';
require_once '../config/config.php';
require_once '../app/Controllers/PrayersController.php';

Routes::defineRoutes();
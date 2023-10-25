<?php
require_once '../Routes/Routes.php';
require_once '../config/config.php';
require_once '../app/Controllers/PrayersController.php';

$prayersController = new PrayersController();
Routes::defineRoutes($prayersController);

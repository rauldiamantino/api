<?php
class Routes
{
  public static function defineRoutes()
  {
    $arrayUri = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($arrayUri);

    if (reset($arrayUri) == 'api') {
      array_shift($arrayUri);

      $method = strtolower($_SERVER['REQUEST_METHOD']);
      $controllerName = ucFirst(reset($arrayUri)) . 'Controller';
      array_shift($arrayUri);

      $controller = new $controllerName;
      $params = $arrayUri;

      $response = call_user_func_array([ $controller, $method ], $params);
    }
  }
}
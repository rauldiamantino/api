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

      if (! is_array($response) or ! isset($response['httpCode'])) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => ['Erro interno no servidor'], 'data' => []]);
        exit;
      }

      http_response_code($response['httpCode']);
      array_shift($response);

      echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      exit;
    }
  }
}
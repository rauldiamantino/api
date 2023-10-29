<?php
/**
 * Routes - Manages the application routing system
 */
class Routes
{  
  /**
   * defineRoutes - Retrieves the path and directs the application
   *
   * @return void
   */
  public static function defineRoutes(): void
  {
    $arrayUri = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($arrayUri);

    if (reset($arrayUri) == 'api') {
      self::apiRequest($arrayUri);
    }
  }
  
  /**
   * apiRequest - Retrieves the routes and directs for the controllers
   *
   * @param  array $arrayUri - The path with the routes related to our API
   * @return void
   */
  private static function apiRequest($arrayUri): void
  {
    if (Authenticator::authenticate() === false) {
      $response = [
        'status' => 'error',
        'message' => ['Acesso não autorizado'],
        'data' => []
      ];

      http_response_code(401);
      echo json_encode($response, JSON_FORMAT);
      exit;
    }

    array_shift($arrayUri);
    $controllerName = ucFirst(reset($arrayUri)) . 'Controller';
    $controller = new $controllerName;
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    array_shift($arrayUri);
    $params = $arrayUri;

    $response = call_user_func_array([ $controller, $method ], $params);

    if (is_array($response) and isset($response['httpCode'])) {
      http_response_code($response['httpCode']);
      array_shift($response);

      echo json_encode($response, JSON_FORMAT);
      exit;
    }

    $response = [
      'status' => 'error',
      'message' => ['Erro interno no servidor'],
      'data' => []
    ];

    http_response_code(500);
    echo json_encode($response, JSON_FORMAT);
    exit;

  }
}
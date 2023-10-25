<?php
class Routes
{
  public static function defineRoutes($prayersController)
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    try {
      if ($method === 'GET' and $path === '/api/prayers') {
        $prayersController->getPrayers();
      }
      elseif (preg_match('/^\/api\/prayer\/(\d+)$/', $path, $matches) and $method === 'GET') {
        $id = $matches[1];
        $prayersController->getPrayer($id);
      }
      elseif ($method === 'POST' and $path === '/api/prayer') {
        $prayersController->requestPrayer();
      }
      elseif (preg_match('/^\/api\/prayer\/update\/(\d+)$/', $path, $matches) and $method === 'PUT') {
        $id = $matches[1];
        $prayersController->updatePrayer($id);
      }
      elseif (preg_match('/^\/api\/prayer\/delete\/(\d+)$/', $path, $matches) and $method === 'DELETE') {
        $id = $matches[1];
        $prayersController->deletePrayer($id);
      }
      else {
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada'], JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
      }
    }
    catch (Exception $e) {
      http_response_code($e->getCode());
      echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
  }
}
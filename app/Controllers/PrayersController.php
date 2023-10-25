<?php
require_once '../app/Models/PrayersModel.php';

class PrayersController
{
  public $prayersModel;

  public function __construct()
  {
    $this->prayersModel = new PrayersModel();
    header('Content-Type: application/json; charset=utf-8');
  }

  public function getPrayers()
  {
    try {
      $allPrayers = $this->prayersModel->getPrayers();

      if (empty($allPrayers)) {
        http_response_code(404);
        echo json_encode(['error' => 'Nenhuma oração encontrada'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }
      else {
        echo json_encode($allPrayers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }
    }
    catch (Exception $e) {
      http_response_code($e->getCode());
      echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
  }

  public function getPrayer($id)
  {
    try {
      $prayer = $this->prayersModel->getPrayers($id);

      if (empty($prayer)) {
        http_response_code(404);
        echo json_encode(['error' => 'Nenhuma oração encontrada'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }
      else {
        echo json_encode($prayer, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      }
    }
    catch (Exception $e) {
      http_response_code($e->getCode());
      echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
  }

  public function requestPrayer()
  {
    try {
      $this->validateHeaders();
      $body = json_decode(file_get_contents("php://input"), true);

      $response = [
        'id' => 1,
        'name' => 'Raul',
        'title' => 'Oração pela família',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat rem sapiente delectus numquam hic magnam dicta laudantium omnis, doloremque modi, tempora, architecto culpa qui ab mollitia voluptatum. Quod, magni est?',
        'status' => 0,
        'created_at' => time(),
        'updated_at' => time(),
      ];

      echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    catch (Exception $e) {
      http_response_code($e->getCode());
      echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
  }

  public function updatePrayer($id)
  {
    try {
      $this->validateHeaders();
      $body = json_decode(file_get_contents("php://input"), true);

      $response = [
        'id' => 1,
        'name' => 'Raul',
        'title' => 'Oração pela família',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat rem sapiente delectus numquam hic magnam dicta laudantium omnis, doloremque modi, tempora, architecto culpa qui ab mollitia voluptatum. Quod, magni est?',
        'status' => 0,
        'created_at' => time(),
        'updated_at' => time(),
      ];

      echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    catch (Exception $e) {
      http_response_code($e->getCode());
      echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
  }

  public function deletePrayer()
  {

  }

  private function validateHeaders()
  {
      $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

      if (empty($contentType)) {
          throw new Exception('O cabeçalho Content-Type: application/json é obrigatório.', 400);
      }

      if ($contentType !== 'application/json') {
          throw new Exception('Content-Type não suportado, use application/json', 415);
      }
  }
}
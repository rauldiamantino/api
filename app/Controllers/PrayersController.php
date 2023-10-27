<?php
require_once '../app/Models/PrayersModel.php';

class PrayersController
{
  public $prayersModel;
  public $prayersExceptions;

  public function __construct()
  {
    $this->prayersModel = new PrayersModel();
    $this->prayersExceptions = new stdClass();
  }

  public function get($id = null)
  {
    $result = [];

    if ($id) {
      $result = $this->prayersModel->selectPrayer($id);
    }
    else {
      $result = $this->prayersModel->selectAllPrayers();
    }

    if ($result) {
      http_response_code(200);
      echo json_encode(['status' => 'success', 'data' => $result ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    http_response_code(400);
    $response = ['status' => 'error', 'data' => ['message' => 'Nenhum pedido de oração encontrado']];
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
  }

  public function post()
  {
    $this->validateHeaders();
    $request = json_decode(file_get_contents("php://input"), true);

    $bodyRequest = [
      'userId' => $request['userId'],
      'title' => $request['title'],
      'description' => $request['description'],
      'status' => $request['status'],
      'createdAt' => $request['createdAt'],
      'updatedAt' => $request['updatedAt'],
    ];

    $message = [];
    foreach ($bodyRequest as $key => $value):
      if ($key == 'userId') {
        $message[ $key ] = ['message' => $this->validateUserId($value)];
      }
      elseif ($key == 'title') {
        $message[ $key ] = ['message' => $this->validateTitle($value)];
      }
      elseif ($key == 'description') {
        $message[ $key ] = ['message' => $this->validateDescription($value)];
      }
      elseif ($key == 'status') {
        $message[ $key ] = ['message' => $this->validateStatus($value)];
      }
      elseif ($key == 'createdAt') {
        $message[ $key ] = ['message' => $this->validateCreatedAt($value)];
      }
      elseif ($key == 'updatedAt') {
        $message[ $key ] = ['message' => $this->validateUpdatedAt($value)];
      }

      if (empty($message[ $key ]['message'])) {
        unset($message[ $key ]);
      }
    endforeach;

    if ($message) {
      http_response_code(400);
      echo json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    if ($this->prayersModel->addPrayer($bodyRequest)) {
      http_response_code(201);
      $response = ['status' => 'success', 'data' => ['message' => 'Pedido de oração cadastrado com sucesso!']];
      echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    http_response_code(400);
    $message = ['status' => 'error', 'data' => ['message' => 'Erro ao cadastrar pedido de oração.']];
    echo json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
  }

  public function put($id)
  {
    $this->validateHeaders();
    $request = json_decode(file_get_contents("php://input"), true);

    // revisar
    if (empty($id)) {
      http_response_code(400);
      $response = ['status' => 'error', 'data' => ['message' => 'Informe o id do pedido de oração!']];
      echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    $bodyRequest = [
      'userId' => $request['userId'],
      'title' => $request['title'],
      'description' => $request['description'],
      'status' => $request['status'],
      'createdAt' => $request['createdAt'],
      'updatedAt' => $request['updatedAt'],
    ];

    $message = [];
    foreach ($bodyRequest as $key => $value):
      if ($key == 'userId') {
        $message[ $key ] = ['message' => $this->validateUserId($value)];
      }
      elseif ($key == 'title') {
        $message[ $key ] = ['message' => $this->validateTitle($value)];
      }
      elseif ($key == 'description') {
        $message[ $key ] = ['message' => $this->validateDescription($value)];
      }
      elseif ($key == 'status') {
        $message[ $key ] = ['message' => $this->validateStatus($value)];
      }
      elseif ($key == 'createdAt') {
        $message[ $key ] = ['message' => $this->validateCreatedAt($value)];
      }
      elseif ($key == 'updatedAt') {
        $message[ $key ] = ['message' => $this->validateUpdatedAt($value)];
      }

      if (empty($message[ $key ]['message'])) {
        unset($message[ $key ]);
      }
    endforeach;

    if ($message) {
      http_response_code(400);
      echo json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    if ($this->prayersModel->updatePrayer($bodyRequest, $id)) {
      http_response_code(201);
      $response = ['status' => 'success', 'data' => ['message' => 'Pedido de oração atualizado com sucesso!']];
      echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      exit;
    }

    http_response_code(400);
    $message = ['status' => 'error', 'data' => ['message' => 'Erro ao atualizar pedido de oração.']];
    echo json_encode($message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
  }

  public function delete()
  {
    return 'delete';
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

  private function validateUserId($userId)
  {
    if (empty($userId)) {
      return 'Não pode ser vazio.';
    }
    if (is_int($userId) == false or $userId < 1) {
      return 'Tipo inválido ou valor menor que 1.';
    }
    elseif (empty($userId)) {
      return 'Não pode ser vazio.';
    }
  }

  private function validateTitle($title)
  {
    if (empty($title)) {
      return 'Não pode ser vazio.';
    }
    elseif (is_string($title) == false) {
      return 'Tipo inválido.';
    }
    elseif (strlen($title) == 80) {
      $message['status'] = 'error';
      return 'Quantidade de caracteres excedida.';
    }
  }

  private function validateDescription($description)
  {
    if (empty($description)) {
      return 'Não pode ser vazio.';
    }
    elseif (is_string($description) == false) {
      return 'Tipo inválido.';
    }
    elseif (strlen($description) == 80) {
      return 'Quantidade de caracteres excedida.';
    }
  }

  private function validateStatus($status)
  {
    if (empty($status)) {
      return 'Não pode ser vazio.';
    }
    elseif (is_bool($status) == false) {
      return 'Tipo inválido.';
    }
  }

  private function validateCreatedAt($createdAt)
  {
    if (empty($createdAt)) {
      return 'Não pode ser vazio.';
    }
    elseif (DateTime::createFromFormat('Y-m-d', $createdAt) == false) {
      return 'Formato de data inválida.';
    }
  }

  private function validateUpdatedAt($updatedAt)
  {
    if (empty($updatedAt)) {
      return 'Não pode ser vazio.';
    }
    elseif (DateTime::createFromFormat('Y-m-d', $updatedAt) == false) {
      return 'Formato de data inválida.';
    }
  }
}
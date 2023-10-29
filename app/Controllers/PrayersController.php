<?php
require_once '../app/Models/PrayersModel.php';

class PrayersController
{
  public $prayersModel;

  public function __construct()
  {
    $this->prayersModel = new PrayersModel();
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

    if (empty($result)) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => ['Nenhum pedido de oração encontrado'],
        'data' => []
      ];

      return $response;
    }

    $response = [
      'httpCode' => 200,
      'status' => 'success',
      'message' => ['Registro(s) encontrado(s)'],
      'data' => $result
    ];

    return $response;
  }

  public function post()
  {
    $requestJson = file_get_contents("php://input");
    $requestArray = json_decode($requestJson, true);

    if (empty($requestArray)) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => ['Requisição inválida'],
        'data' => []
      ];

      return $response;
    }

    $errorsRequestBody = $this->validateRequestBody($requestArray);

    if ($errorsRequestBody) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => $errorsRequestBody,
        'data' => []
      ];

      return $response;
    }

    if ($requestArray['status'] === false) {
      $requestArray['status'] = 0;
    }

    if (empty($this->prayersModel->addPrayer($requestArray))) {
      return false;
    }

    $response = [
      'httpCode' => 201, 
      'status' => 'success', 
      'message' => ['Pedido de oração cadastrado'], 
      'data' => []
    ];

    return $response;
  }

  public function put($id)
  {
    $requestJson = file_get_contents("php://input");
    $requestArray = json_decode($requestJson, true);

    if (empty($id) or empty($requestArray)) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => ['Requisição inválida'],
        'data' => []
      ];

      return $response;
    }

    $errorsRequestBody = $this->validateRequestBody($requestArray);

    if ($errorsRequestBody) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => $errorsRequestBody,
        'data' => []
      ];

      return $response;
    }

    if ($requestArray['status'] === false) {
      $requestArray['status'] = 0;
    }

    if (empty($this->prayersModel->updatePrayer($requestArray, $id))) {
      return false;
    }

    $response = [
      'httpCode' => 201, 
      'status' => 'success', 
      'message' => ['Pedido de oração atualizado'], 
      'data' => []
    ];

    return $response;
  }

  public function delete($id)
  {
    if (empty($id)) {
      $response = [
        'httpCode' => 400,
        'status' => 'error',
        'message' => ['Requisição inválida'],
        'data' => []
      ];

      return $response;
    }

    if (empty($this->prayersModel->deletePrayer($id))) {
      return false;
    }

    $response = [
      'httpCode' => 201,
      'status' => 'success',
      'message' => ['Pedido de oração excluído'],
      'data' => []
    ];

    return $response;
  }

  private function validateRequestBody($request)
  {
    $errors = [];
    $errors[] = Validator::validateUserId($request['userId']);
    $errors[] = Validator::validateTitle($request['title']);
    $errors[] = Validator::validateDescription($request['description']);
    $errors[] = Validator::validateStatus($request['status']);
    $errors[] = Validator::validateCreatedAt($request['createdAt']);
    $errors[] = Validator::validateUpdatedAt($request['updatedAt']);

    $validErrors = array_filter($errors);
    return $validErrors;
  }
}
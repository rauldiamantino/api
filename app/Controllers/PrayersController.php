<?php
require_once '../app/Models/PrayersModel.php';

/**
 * PrayersController - Provides methods to retrieve, create, update and delete prayer requests
 */
class PrayersController
{  
  /**
   * prayersModel
   *
   * @var object
   */
  public $prayersModel;
  
  /**
   *
   * __construct - Initializes the model responsible for prayer requests
   *
   * @return void
   */
  public function __construct()
  {
    $this->prayersModel = new PrayersModel();
  }
  
  /**
   * get - Gets a prayer request or list of all prayer requests
   *
   * @param int $id - The ID of the prayer request to be obtained (Optional)
   * @return array - Returns an array with the details of the order or all orders
   */
  public function get(int $id = 0): array
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
  
  /**
   * post - Register prayer request in the database
   *
   * @return array - Returns an array with the request response
   */
  public function post(): array
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
      $response = [
        'httpCode' => 500,
        'status' => 'error',
        'message' => ['Erro interno no servidor'],
        'data' => []
      ];

      return $response;
    }

    $response = [
      'httpCode' => 201, 
      'status' => 'success', 
      'message' => ['Pedido de oração cadastrado'], 
      'data' => []
    ];

    return $response;
  }
  
  /**
   * put - Updates prayer request in the database
   *
   * @param int $id - The ID of the prayer request to be updated
   * @return array - Returns an array with the request response
   */
  public function put(int $id): array
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
      $response = [
        'httpCode' => 500,
        'status' => 'error',
        'message' => ['Erro interno no servidor'],
        'data' => []
      ];

      return $response;
    }

    $response = [
      'httpCode' => 201, 
      'status' => 'success', 
      'message' => ['Pedido de oração atualizado'], 
      'data' => []
    ];

    return $response;
  }

  /**
   * delete - Deletes prayer request in the database
   *
   * @param int $id - The ID of the prayer request to be updated
   * @return array - Returns an array with the request response
   */
  public function delete(int $id): array
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
     $response = [
        'httpCode' => 500,
        'status' => 'error',
        'message' => ['Erro interno no servidor'],
        'data' => []
      ];

    }

    $response = [
      'httpCode' => 201,
      'status' => 'success',
      'message' => ['Pedido de oração excluído'],
      'data' => []
    ];

    return $response;
  }
  
  /**
   * validateRequestBody - Validates the fields received in the request
   *
   * @param $request array - Request fields
   * @return array - Returns an array with the request response
   */
  private function validateRequestBody(array $request): array
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
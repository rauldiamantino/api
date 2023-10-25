<?php
require_once '../config/Database.php';

class PrayersModel
{
  public $database;

  public function __construct()
  {
    $this->database = new Database();
  }

  public function getPrayers($id = 0)
  {
    $query = 'SELECT * FROM prayer_requests';

    if ($id) {
      $query .= ' WHERE id = :id';
      $params = ['id' => $id ];
    }

    $response = $this->database->select($query, $params ?? []);
    return $response;
  }
}

<?php
require_once 'Database.php';

class PrayersModel
{
  public $database;

  public function __construct()
  {
    $this->database = new Database();
  }

  public function selectPrayer($id)
  {
    $query = 'SELECT * FROM prayer_requests WHERE id = :id';
    $result = $this->database->select($query, ['id' => $id ]);

    return $result;
  }

  public function selectAllPrayers()
  {
    $query = 'SELECT * FROM prayer_requests';
    $result = $this->database->select($query);

    return $result;
  }

  public function addPrayer($data)
  {
    $query = 'INSERT INTO prayer_requests (user_id, title, description, status, created_at, updated_at)
              VALUES (:user_id, :title, :description, :status, :created_at, :updated_at)';

    $params = [
      'user_id' => $data['userId'],
      'title' => $data['title'],
      'description' => $data['description'],
      'status' => $data['status'],
      'created_at' => $data['createdAt'],
      'updated_at' => $data['updatedAt']
    ];

    $result = $this->database->insert($query, $params);
    return $result;
  }

  public function updatePrayer($data, $id)
  {
    $query = 'UPDATE prayer_requests
              SET user_id = :user_id,
                  title = :title,
                  description = :description,
                  status = :status, 
                  created_at = :created_at,
                  updated_at = :updated_at
              WHERE id = :id';

    $params = [
      'id' => $id,
      'user_id' => $data['userId'],
      'title' => $data['title'],
      'description' => $data['description'],
      'status' => $data['status'],
      'created_at' => $data['createdAt'],
      'updated_at' => $data['updatedAt'],
    ];

    $result = $this->database->insert($query, $params);
    return $result;
  }

  public function deletePrayer($id)
  {
    $query = 'DELETE FROM prayer_requests
              WHERE id = :id';

    $params = ['id' => $id ];

    $result = $this->database->delete($query, $params);
    return $result;
  }
}
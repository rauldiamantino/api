<?php
require_once 'Database.php';

/**
 * PrayersModel - Provides methods for prepares manipulating the database
 */
class PrayersModel
{  
  /**
   * database
   *
   * @var object
   */
  public $database;
  
  /**
   * __construct - Initializes the database object
   *
   * @return void
   */
  public function __construct()
  {
    $this->database = new Database();
  }

  /**
   * selectPrayer - Prepares query to gets a prayer request
   *
   * @param int $id - The ID of the prayer request to be obtained
   * @return array - Returns an array with the details of the order
   */
  public function selectPrayer(int $id): array
  {
    $query = 'SELECT * FROM prayer_requests WHERE id = :id';
    $result = $this->database->select($query, ['id' => $id ]);

    return $result;
  }

  
  /**
   * selectAllPrayers - Prepares consultation to get all prayer requests
   *
   * @return array - Returns an array with the details of the all orders
   */
  public function selectAllPrayers(): array
  {
    $query = 'SELECT * FROM prayer_requests';
    $result = $this->database->select($query);

    return $result;
  }
  
  /**
   * addPrayer - Prepares query for insertion of the prayer request in the database
   *
   * @param  array $data - Prayer Request 
   * @return bool - Returns positive or false for insertion attempt
   */
  public function addPrayer(array $data): bool
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

  /**
   * updatePrayer - Prepares query for update of the prayer request in the database
   *
   * @param  array $data - Prayer Request
   * @param int $id - The ID of the prayer request to be updated
   * @return bool - Returns positive or false for update attempt
   */
  public function updatePrayer(array $data, int $id): bool
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

  /**
   * deletePrayer - Prepares query for deletion of the prayer request in the database
   *
   * @param  array $id - The ID of the prayer request to be deleted
   * @return bool Returns positivo or false for delete attempt
   */
  public function deletePrayer(int $id): bool
  {
    $query = 'DELETE FROM prayer_requests
              WHERE id = :id';

    $params = ['id' => $id ];

    $result = $this->database->delete($query, $params);
    return $result;
  }
}
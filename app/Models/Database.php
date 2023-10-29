<?php

/**
 * Database - Provides methods for manipulating the database
 */
class Database
{  
  /**
   * connection
   *
   * @var object
   */
  private $connection;
  
  /**
   * __construct - Initializes the database object
   *
   * @return void
   */
  public function __construct()
  {
    $this->connect();
  }
  
  /**
   * connect - Connects to the database
   *
   * @return void
   */
  private function connect(): void
  {
    try {
      $this->connection = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD
      );

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
      throw new Exception('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }
  }

    
  /**
   * select - Queries the database
   *
   * @param  string $query - Query-ready SQL
   * @param  array $params - Parameters to add to the query
   * @return array - Returns query performed on the database 
   */
  public function select(string $query, array $params = []): array
  {
    try {
      $stmt = $this->connection->prepare($query);
      $stmt->execute($params);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      throw new Exception('Erro na consulta ao banco de dados: ' . $e->getMessage());
    }
  }

  
  /**
   * insert - Adds records to the database
   *
   * @param  string $query - Query-ready SQL
   * @param  array $params - Parameters to add to the query
   * @return bool - Returns positive or false for insertion attempt
   */
  public function insert(string $query, array $params = []): bool
  {
    $stmt = $this->connection->prepare($query);

    foreach ($params as $key => &$value):
      $stmt->bindParam(":$key", $value);
    endforeach;

    try {
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        return false;
      }

      return true;
    }
    catch (PDOException $e) {
      throw new Exception('Erro ao adicionar no banco de dados');
    }
  }
  
  /**
   * delete - Deletes records from the database
   *
   * @param  string $query - Query-ready SQL
   * @param  array $params - Parameters to add to the query
   * @return bool - Returns positive or false for delete attempt
   */
  public function delete(string $sql, array $params = []): bool
  {
    $stmt = $this->connection->prepare($sql);

    foreach ($params as $key => &$value):
      $stmt->bindParam(":$key", $value);
    endforeach;

    try {
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
          return false;
      }

      return true;
    }
    catch (PDOException $e) {
      throw new Exception('Erro ao apagar registro do banco de dados');
    }
  }
}

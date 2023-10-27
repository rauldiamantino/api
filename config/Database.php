<?php
class Database
{
  private $connection;
  private $host;
  private $dbname;
  private $username;
  private $password;

  public function __construct()
  {
    $this->host = DB_HOST;
    $this->dbname = DB_NAME;
    $this->username = DB_USER;
    $this->password = DB_PASSWORD;

    $this->connect();
  }

  private function connect()
  {
    try {
      $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8', $this->username, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
      throw new Exception('Erro na conexão com o banco de dados: ' . $e->getMessage());
    }
  }

  public function select($query, $params = [])
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

  public function insert($query, $params = [])
  {
    $stmt = $this->connection->prepare($query);

    foreach ($params as $key => &$value) {
      $stmt->bindParam(":$key", $value);
    }

    try {
      return $stmt->execute();
    }
    catch (PDOException $e) {
      throw new Exception('Erro ao adicionar no banco de dados');
    }
  }
}

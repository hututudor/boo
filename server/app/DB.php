<?php

class DB {
  private ?mysqli $connection;
  private static ?DB $instance = null;

  private function __construct() {
    try {
      $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      if(!$this->connection) {
        throw new mysqli_sql_exception("no connection");
      }
    } catch (mysqli_sql_exception $e) {
      trigger_error('db not connected ' . $e->getMessage(), E_USER_ERROR);
    }
  }

  public static function getInstance(): DB {
    if (self::$instance == null) {
      self::$instance = new DB;
    }

    return self::$instance;
  }

  public function getConnection(): ?mysqli {
    if(!$this->connection) {
      trigger_error('db not connected yet', E_USER_ERROR);
    }

    return $this->connection;
  }
}
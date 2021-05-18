<?php
class Database {

  private $conn;

  public function __construct() {
    $this->conn = @new mysqli(getenv('DB_URL').':'.getenv('DB_PORT'), getenv('DB_USER') , getenv('DB_PSW'), getenv('DB_NAME'));
    if ($this->conn->connect_error) {
      // echo $this->conn->connect_error;
      throw new DatabaseException("For devs only: <span class='bold'>you</span> probably forgot to turn on the database duh!🤦‍♂️");
    }
  }
  
  public function get(string $select, string $from, string $rest = '') {
    if ($this->conn->ping()) {
      $tmp = $this->conn->query("SELECT $select FROM $from $rest");
      if ($tmp) {
        if ($tmp->num_rows <= 0) throw new NotFoundException();
        else if ($tmp->num_rows == 1) return $tmp->fetch_assoc();
        else {
          $r = [];
          while ($row = $tmp->fetch_assoc()) { array_push($r, $row); }
          return $r;
        }
      } else throw new DatabaseException($this->conn->error);
    }
  }

  public function put(array $ins, string $table) {
    if ($this->conn->ping()) {
      $insert = '';
      $values = '';
      foreach ($ins as $column => $value) {
        $insert .= $column . ', ';
        if (!is_numeric($value)) $value = "'" . $this->conn->real_escape_string($value) . "'";
        $values .= $value.', ';
      }
      $insert = substr($insert, 0, -2);
      $values = substr($values, 0, -2);
      $tmp = $this->conn->query("INSERT INTO $table ($insert) VALUES ($values)");
      if ($tmp) {
        $id = $this->conn->query('SELECT LAST_INSERT_ID()');
        if ($id) return $id->fetch_row()[0];
      } else throw new DatabaseException($this->conn->error, 1);
    }
  }

  public function update(array $upd, string $table, string $where = '') {
    if ($this->conn->ping()) {
      $set = '';
      foreach ($upd as $column => $value) {
        $set .= "$column = $value, ";
      }
      $set = substr($set, 0, -2);
      $tmp = $this->conn->query("UPDATE $table SET $set WHERE $where");
      if (!$tmp) throw new DatabaseException($this->conn->error, 1);
      else {
        preg_match_all('/\d+/', $this->conn->info, $res);
        $res = $res[0];
        if ($res[0] == 0) throw new NotFoundException();
        if ($res[1] == 0) return 'update-not-needed';
        if ($res[0] == 1 && $res[1] == 1) return 'success';
      }
    }
  }

  public function delete(string $table, string $where = '') {
    if ($this->conn->ping()) {
      $tmp = $this->conn->query("DELETE FROM $table WHERE $where");
      if (!$tmp) throw new DatabaseException($this->conn->error, 1);
      else if ($this->conn->affected_rows == 0) throw new NotFoundException();
    }
  }

  public function getConnection() {
    return $this->conn;
  }

  public function close() {
    if ($this->conn) $this->conn->close();
  }

}
?>
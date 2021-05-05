<?php

class User {

  private $user = null;
  public $loggedIn = false;

  public function __construct(string $username = '', string $password = '') {
    if (!empty($username) && !empty($password)) $this->login($username, $password);
    else {
      if (!empty($_SESSION['user'])) $this->set($_SESSION['user']);
    }
  }
  
  public function login(string $username, string $password) {
    $db = new Database();

    $user = $db->get('username, password, scope, name, surname', 'users', "WHERE username = '$username'");
    
    if (password_verify($password, $user['password'])) {
      unset($user['password']);
      $this->user = $user;
      $this->loggedIn = true;
      $_SESSION['user'] = $this->serialize();
    } else throw new PasswordException();
    
    $db->close();
  }

  public function serialize() {
    return serialize($this->user);
  }
  public function set($val) {
    $this->user = unserialize($val);
    $this->loggedIn = true;
  }

  public function update($city = null, $fav_car = null) {
    $db = new Database();
    $u = [];
    $city = Utils::generateCityCode($city);
    if (!empty($city)) $u['city'] = "'$city'";
    if (!empty($fav_car)) $u['fav_car'] = "'$fav_car'";
    $username = $this->user['username'];
    $user = $db->update($u, 'users', "username = '$username'");
    
    $db->close();
  }

  public function getUser() {
    return $this->user;
  }
  public function getFullUser() {
    if ($this->loggedIn) {
      $db = new Database();
      $user = $db->get('*', 'users', "WHERE username = '".$this->user['username']."'");
      $db->close();
      return $user;
    } else throw new UserException('User is not logged');
  }

  public function logout() {
    $this->user = null;
    $this->loggedIn = false;
  }

  public function isAdmin() {
    return $this->user['scope'] == 'admin';
  }
  
  public static function signup($username, $password, $email, $name, $surname, $age, $city, $fav_car, $scope = 'user') {
    if (!$username) throw new UserException('Username required');
    if (!$password) throw new PasswordException('Password required');

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $city = Utils::generateCityCode($city);
    
    $db = new Database();

    try {
      $els = [
        'username' => $username,
        'password' => $hash,
        'email' => strtolower($email),
        'scope' => $scope,
        'name' => ucwords($name),
        'surname' => ucwords($surname),
        'age' => $age,
        'city' => $city,
        'fav_car' => !empty($fav_car) ? ucwords($fav_car) : $fav_car
      ];

      $db->put($els, 'users');
      $db->close();
      return true;
    } catch (Exception $e) {
      $e = $e->getMessage();
      $db->close();
      return $e;
    }
  }

  public static function createTemp($name, $surname, $email, $age = null) {
    $db = new Database();
    $els = [
      'username' => $email,
      'email' => $email,
      'scope' => 'temp',
      'name' => ucwords($name),
      'surname' => ucwords($surname),
      'age' => $age
    ];
    $db->put($els, 'users');
    $db->close();
    return $els;
  }
}
?>
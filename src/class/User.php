<?php

class User {

  private $user = null;
  public $loggedIn = false;

  public function __construct($username = '', $password = '') {
    if (!empty($username) && !empty($password)) $this->login($username, $password);
    else {
      if (!empty($_SESSION['user'])) $this->set($_SESSION['user']);
      else if (!empty($_COOKIE['user_tkn'])) {
        try {
          $this->login(Token::decode($_COOKIE['user_tkn'], getenv('TOKEN_KEY'))['username']);
        } catch (Exception $e) { Utils::deleteCookie('user_tkn'); }
      }
    }
  }
  
  public function login($username = '', $password = null) {
    if (Utils::isAssoc($username)) {
      $this->user = $username;
      $this->loggedIn = true;
      $_SESSION['user'] = $this->serialize();
    } else {
      $db = new Database();

      $user = $db->get('username, password, scope, name, surname', 'users', "WHERE username = '$username'");
      
      if ($password === null || password_verify($password, $user['password'])) {
        unset($user['password']);
        $this->user = $user;
        $this->loggedIn = true;
        $_SESSION['user'] = $this->serialize();
      } else throw new PasswordException();
      
      $db->close();
    }
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
    if ($city !== null) $u['city'] = "'$city'";
    if ($fav_car !== null) {
      $u['fav_car'] = "'".ucwords($fav_car)."'";
    }
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
    Utils::deleteCookie('user_tkn');
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

      unset($els['password']);
      unset($els['email']);
      unset($els['age']);
      unset($els['city']);
      unset($els['fav_car']);

      return $els;
    } catch (Exception $e) {
      $e = $e->getMessage();
      $db->close();
      return $e;
    }
  }

  public static function createTemp($name, $surname, $email, $age = 0) {
    $db = new Database();
    $created = true;

    try {
      $userData = self::create($db, $name, $surname, $email, $age);
    } catch (DatabaseException $e) {
      $userData = $db->get('*', 'users', "WHERE username = '".$_REQUEST['email']."'");
      unset($userData['password']);
      $created = false;
    }
    $db->close();
    return [
      'data' => $userData,
      'created' => $created
    ];
  }

  private static function create($db, $name, $surname, $email, $age) {
    $els = [
      'username' => $email,
      'email' => $email,
      'scope' => 'temp',
      'name' => ucwords($name),
      'surname' => ucwords($surname),
      'age' => $age
    ];
    $db->put($els, 'users');
    return $els;
  }
}
?>
<?php

set_exception_handler(function($ex) {
  $error = '';
  switch (get_class($ex)) {
    case 'DatabaseException':
      $error = '<p>An error within the database occured, please try again:<br><br>'.$ex->getMessage().'</p>';
      break;
    case 'DieProgramException':
      $error = '<p>🛑A fatal error occured, please contact the site owner:<br><br>'.$ex->getMessage().'</p>';
      break;
    default:
      $error = '<p>⚠️We caught this unknown error, please inform our engineer:<br><br>'.$ex.'</p>';
      break;
  }
  $page = new Template('errorpage');
  $user = new User();
  $userdata = $user->loggedIn ? $user->getUser() : [];
  $page->putDynamicContent(array_merge($userdata, [
    'error' => $error
  ]));
  $page->render();
  exit;
});

class PasswordException extends Exception {
  public function __construct(string $msg = 'Wrong Password') {
    parent::__construct($msg);
  }
}
class UserException extends Exception {
  public function __construct(string $msg = 'User doesn\'t exist') {
    parent::__construct($msg);
  }
}

class DatabaseException extends Exception {
  public function __construct(string $msg = 'An error occured with the database') {
    parent::__construct($msg);
  }
}

class NotFoundException extends DatabaseException {
  public function __construct(string $msg = 'We haven\'t found anything!') {
    parent::__construct($msg);
  }
}

class FileUploadException extends Exception {
  public function __construct(string $msg = 'Error occured during upload') {
    parent::__construct($msg);
  }
}

class TokenException extends Exception {
  public function __construct(string $msg = 'Error in token encoding/decoding') {
    parent::__construct($msg);
  }
}

class DieProgramException extends Exception {
  public function __construct(string $msg = 'A fatal error occured') {
    parent::__construct($msg);
  }
}

?>
<?php

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

class DieProgramException extends Exception {
  public function __construct(string $msg = 'A fatal error occured') {
    parent::__construct($msg);
  }
}

?>
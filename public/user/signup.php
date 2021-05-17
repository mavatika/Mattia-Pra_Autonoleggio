<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/city_list.php');

$user = new User();

if ($user->loggedIn) {
  header('Location:/');
  exit;
}

$page = new Template('signup');

if (count($_POST) > 0) {
  // RICHIAMATO SE STESSO
  $params = Utils::checkParams(['username', 'password', 'password2', 'email', 'name', 'surname', 'bday']);

  $errors = [];
  $e = '';

  if (count($params) == 0) {
    $bday = new DateTime($_REQUEST['bday']);
    $now = new DateTime();
    $age = $now->diff($bday)->y;
    if ($age < 18) array_push($errors, "You're too young to create an account");
    if ($_REQUEST['password'] != $_REQUEST['password2']) array_push($errors, 'Passwords are not equal');

    if (count($errors) == 0) {
      $created = User::signup($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['name'], $_REQUEST['surname'], $age, $_REQUEST['city'], $_REQUEST['fav_car']);
      if (Utils::isAssoc($created)) {
        $user->login($created);
        header('Location:/');
        exit;
      } else {
        preg_match_all("/\'(.*?)\'/", $created, $msg);
        $msg = strlen($msg[0][0]) > 0 ? 'Username already in use' : 'Generic error in database';
        $e .= '
          <p class="server_message error_el">
            '.$msg.'.
          </p>'."\n";
      }
    } else {
      foreach($errors as $err) {
        $e .= '
          <p class="server_message error_el">
            '.$err.'.
          </p>'."\n";
      }
    }   
  } else {
    foreach ($params as $el) {
      $e .= '
          <p class="server_message error_el">
            '.$el.' value is missing, please fill it.
          </p>'."\n";
    }
  }
}

$page->putDynamicContent([
  'errors' => !empty($e) > 0 ? $e : ''
]);

$page->render();

?>
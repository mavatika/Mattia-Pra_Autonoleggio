<?php

session_start();

require_once(__DIR__.'/../src/utils/require.php');
require_once(__DIR__.'/../src/components/city_list.php');

$user = new User();

$deepness = str_repeat('../', Utils::getRequestDeepness());

if ($user->loggedIn) {
  header("Location: $deepness"."index.php");
  exit;
}

$page = new Template('signup');

$requiredParams = ['username', 'password', 'password2', 'email', 'name', 'surname', 'bday'];

if (count($_POST) > 0) {
  // RICHIAMATO SE STESSO
  $params = Utils::checkParams($requiredParams);

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
        header("Location: $deepness"."index.php");
        exit;
      } else {
        $msg = strpos($created, 'Duplicate entry') !== false ? 'Username already in use' : 'Generic error in database';
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

foreach (array_merge($requiredParams, ['fav_car', 'city']) as $rq) {
  $filtered['form_'.$rq] = !empty($_POST[$rq]) ? 'value="'.$_POST[$rq].'"' : '';
}

$page->putDynamicContent(array_merge(
  !empty($filtered) ? $filtered : [],
  [
    'errors' => !empty($e) > 0 ? $e : ''
  ]
));

$page->render();

?>
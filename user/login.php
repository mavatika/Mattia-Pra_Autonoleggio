<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

if ($user->loggedIn) {
  !empty($_REQUEST['to']) ? header('Location: ' . $_REQUEST['to']) : header("Location: /");
  exit;
}

$err = '';

if (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];

  try {
    $user->login($username, $password);
    $_SESSION['user'] = $user->serialize();
    !empty($_REQUEST['to']) ? header('Location: ' . $_REQUEST['to']) : header("Location: /");
    exit;
  } catch (PasswordException $e) {
    $err = '<p class="server_message error_el">Wrong password</p>';
  } catch (NotFoundException $e) {
    $err = '<p class="server_message error_el">Username doesn\'t exist</p>';
  }
}

$page = new Template('login');

$page->putDynamicContent([
  'errors' => $err,
  'to' => !empty($_REQUEST['to']) ? '<input type="hidden" name="to" value="' . $_REQUEST['to'] . '">' : ''
]);

$page->render();

?>
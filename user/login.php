<?php

session_start();

require_once(__DIR__.'/../src/utils/require.php');

$user = new User();

$deepness = str_repeat('../', Utils::getRequestDeepness());

if ($user->loggedIn) {
  !empty($_REQUEST['to']) ? header('Location: ' . $_REQUEST['to']) : header("Location: $deepness"."index.php");
  exit;
}

$err = '';

if (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];

  try {
    $user->login($username, $password);
    $expire = 60 * 60 * 24 * 30;
    if (isset($_REQUEST['keeplogged'])) setcookie('user_tkn', Token::encode([
      'username' => $username
    ], getenv('TOKEN_KEY'), [
      'expiresIn' => $expire
    ]), time() + $expire, $GLOBALS['PROJECT_FOLDER']);
    !empty($_REQUEST['to']) ? header('Location: ' . $_REQUEST['to']) : header("Location: $deepness"."index.php");
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
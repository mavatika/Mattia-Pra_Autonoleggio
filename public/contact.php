<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

if (count($_POST) > 0) {
  try {
    $db = new Database();
    $userData = $user->loggedIn ? $user->getUser() : User::createTemp($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['email']);
    $db->put([
      'user_id' => $userData['username'],
      'message' => $_REQUEST['msg']
    ], 'messages');
    $db->close();
    $msg = '<p class="server_message success_el">Message sent successfully</p>';
  } catch (Exception $e) {
    $msg = '<p class="server_message error_el">An error occured, try again</p>';
  }
}

$page = new Template('contact', !$user->loggedIn);

if ($user->loggedIn) $page->putDynamicContent(array_merge($user->getUser(), [
    'send_error' => isset($msg) ? $msg : ''
  ]));

$page->render();

?>
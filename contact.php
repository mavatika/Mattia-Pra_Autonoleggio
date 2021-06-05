<?php

session_start();

require_once(__DIR__.'/src/utils/require.php');

$user = new User();

if (count($_POST) > 0) {
  try {
    $db = new Database();
    $userData = $user->loggedIn ? $user->getUser() : User::createTemp($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['email'])['data'];
    $db->put([
      'user_id' => $userData['username'],
      'object' => $_REQUEST['obj'],
      'message' => $_REQUEST['msg']
    ], 'messages');
    $db->close();
    $msg = '<p class="server_message success_el">Message sent successfully</p>';
  } catch (Exception $e) {
    $msg = strpos($e->getMessage(), 'Duplicate entry') !== false 
      ? '<p class="server_message error_el">You already sent a message with this object, try with another object</p>'
      : '<p class="server_message error_el">An error occured, try again</p>';
  }
}

$page = new Template('contact', !$user->loggedIn);

if ($user->loggedIn) $page->putDynamicContent($user->getUser());

$page->putDynamicContent([
  'send_error' => isset($msg) ? $msg : ''
]);

$page->render();

?>
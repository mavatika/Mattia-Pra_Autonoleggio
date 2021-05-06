<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();
$page = new Template('homepage', !$user->loggedIn);

unset($_SESSION['car_id']);
if ($user->loggedIn) $page->putDynamicContent($user->getUser());

$page->render();

?>
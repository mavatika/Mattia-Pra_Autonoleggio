<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

if($user->loggedIn) $user->logout();

session_destroy();
session_unset();
header("Location: /");

?>
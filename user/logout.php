<?php

session_start();

require_once(__DIR__.'/../src/utils/require.php');

$user = new User();

if($user->loggedIn) $user->logout();

session_destroy();
session_unset();

$deepness = str_repeat('../', Utils::getRequestDeepness());
header("Location: $deepness"."index.php");

?>
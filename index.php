<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/city_list.php');

$user = new User();
$db = new Database();

$page = new Template('homepage', !$user->loggedIn);

$d = ['cities' => getCities($db)];

if ($user->loggedIn) $d = array_merge($d, $user->getUser());

$db->close();

$page->putDynamicContent($d);
$page->render();

?>
<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/single_car.php');

$user = new User();

$db = new Database();
$page = new Template('cars', !$user->loggedIn);

$rest = '';
$tables = 'cars';

$dynamic = [
  'cars' => ''
];

$userdata = $user->getUser();
try {
  if ($user->loggedIn) {
    $tables .= ', users';
    $rest = "WHERE users.username = '".$userdata['username']."' ORDER BY CASE WHEN brand >= users.fav_car THEN 1 ELSE 0 END DESC, brand ASC";
    $dynamic = array_merge($dynamic, $userdata);
  }
  $cars = $db->get('cars.id, cars.brand, cars.model, cars.image, cars.price, cars.speed, cars.seats, cars.engine', $tables, $rest);
} catch (NotFoundException $e) {
  if ($user->loggedIn) {
    try {
      $db->get('username', 'users', "where username = '". $userdata['username'] ."'");
    } catch (NotFoundException $e) {
      header('Location:/user/logout.php');
    }
  }
}

foreach ($cars as $car) {
  $dynamic['cars'] .= createCar($car);
}

$db->close();

$page->putDynamicContent($dynamic);

$page->render();

?>
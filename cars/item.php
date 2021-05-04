<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

$page = new Template('car_item', !$user->loggedIn);

$db = new Database();

$car = $db->get('*', 'cars, stock', 'where cars.id = stock.car_id AND cars.id = ' . $_GET['id']);

$car['car_link'] = $car['quantity'] > 0 ?
  '<a href="/cars/rent.php?id='.$car['id'].'" class="car_btn primary_btn">RENT THIS CAR</a>' :
  '<button disabled class="car_btn primary_btn" title="We\'re sorry but this car is not available for rent">Car not available</button>';

$car['gps'] = $car['gps'] == 1 ? 'Yes' : 'No';

if ($user->loggedIn) $car = array_merge($car, $user->getUser());

$page->putDynamicContent($car);

$db->close();

$page->render();

unset($page);
unset($db);
unset($user);

?>
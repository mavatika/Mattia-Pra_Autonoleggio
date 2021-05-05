<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

$page = new Template('car_item', null, false);

$db = new Database();
$car = [];
$useStatic = false;

try {
  $car = $db->get('*', 'cars, stock', 'where cars.id = stock.car_id AND cars.id = ' . $_GET['id']);
  $_SESSION['car_id'] = $_GET['id'];

  $car['car_link'] = $car['quantity'] > 0 ?
    '<a href="/cars/rent.php" class="car_btn primary_btn">RENT THIS CAR</a>' :
    '<button disabled class="car_btn primary_btn" title="We\'re sorry but this car is not available for rent">Car not available</button>';

  $car['gps'] = $car['gps'] == 1 ? 'Yes' : 'No';
} catch (NotFoundException $e) {
  $useStatic = true;
}

if ($user->loggedIn) $car = array_merge($car, $user->getUser());
$page->useStatic($useStatic);

$page->putDynamicContent($car);
$db->close();
$page->render();

?>
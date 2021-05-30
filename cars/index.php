<?php

session_start();

require_once(__DIR__.'/../src/utils/require.php');
require_once(__DIR__.'/../src/components/single_car.php');

$user = new User();

$db = new Database();
$page = new Template('cars', !$user->loggedIn);

$rest = ['(cars.id = stock.car_id)'];
$tables = 'cars, stock';

$cars = [];

$dynamic = [
  'cars' => ''
];

$userdata = $user->getUser();
try {
  if (!empty($_GET['filter'])) {
    array_push($rest, "(brand LIKE '%".$_GET['filter']."%' OR model LIKE '%".$_GET['filter']."%' OR category LIKE '%".$_GET['filter']."%')");
  }
  if ($user->loggedIn) {
    $tables .= ', users';
    array_push($rest, "(users.username = '".$userdata['username']."') ORDER BY CASE WHEN brand >= users.fav_car THEN 1 ELSE 0 END DESC, brand ASC");
    $dynamic = array_merge($dynamic, $userdata);
  }

  if (count($rest) > 1) {
    $rest = "WHERE " . join(' AND ', $rest);
    if ($user->loggedIn) $rest = substr($rest, 0, -4);
  } else if (count($rest) == 1) $rest = "WHERE " . $rest[0];
  else $rest = '';

  $cars = $db->get('cars.id, cars.brand, cars.model, cars.image, cars.price, cars.speed, cars.seats, cars.engine, stock.quantity', $tables, $rest);
} catch (NotFoundException $e) {
  if ($user->loggedIn) {
    try {
      $db->get('username', 'users', "where username = '". $userdata['username'] ."'");
    } catch (NotFoundException $e) {
      header('Location:../user/logout.php');
      exit;
    }
  }
}

if (count($cars) > 0) {
  if(Utils::isAssoc($cars)) $cars = [$cars];
  foreach ($cars as $car) {
    $dynamic['cars'] .= createCar($car);
  }
} else $dynamic['cars'] = "
  <div class='link_to_page'>
    <h3>We're sorry! We haven't found anything that matched '".$_GET['filter']."'</h3>
    <p>
      <a href='/cars/'>Try giving a look at our <span class='link bold'>full motor pool!</span></a>
    </p>
  </div>
";


$dynamic['filter_car'] = !empty($_GET['filter']) && count($cars) > 0 ? "'".$_GET['filter']."'" : '';

$db->close();

$page->putDynamicContent($dynamic);

$page->render();

?>
<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Token.php');
$user = new User();
$db = new Database();

if (!empty($_GET['rent'])) {
  $rentID = $_GET['rent'];
} else if (empty($_GET['rent']) && !empty($_SESSION['rent'])) {
  $rentID = $_SESSION['rent'];
} else {
  $rentID = null;
}

if (empty($rentID) && !empty($_SESSION['temp_user'])) unset($_SESSION['temp_user']);

$useStatic = (!$user->loggedIn && empty($_SESSION['temp_user']) && empty($_GET['email'])) || empty($rentID);
$page = new Template('rented', null, false);

$userData = [];
if ($user->loggedIn) $userData = $user->getUser();

$page->putDynamicContent(array_merge($userData, [
  'should_ask_email' => empty($rentID) && !$user->loggedIn && empty($_SESSION['temp_user']) ? '<div class="input_wrapper">
            <label for="email">Type the email you used to rent the car</label>
            <input type="email" name="email" id="email" autocomplete="email" placeholder="mario.rossi@dominio.it" required>
          </div>' : ''
]));

if (
      ($user->loggedIn || 
        (!$user->loggedIn && (!empty($_SESSION['temp_user']) || !empty($_GET['email'])))
      ) && !empty($rentID)
    ) {

  $queryRes = '';
  
  try {
    $userID = $user->loggedIn ? 
      $userData['username'] : 
      (!empty($_SESSION['temp_user']) ? 
        $_SESSION['temp_user'] : 
        (!empty($_GET['email']) ?
          $_GET['email'] : ''));
    $car = $db->get(
      'users.name AS rent_user, cars.brand, cars.model, cars.price, cars.img1, cars.id as car_id, cities.name as city, cities.address, rents.startDate, rents.duration',
      'cars, cities, rents, users',
      "WHERE users.username = rents.user_id AND cars.id = rents.car_id AND cities.code = rents.city AND (users.username = '$userID' OR users.email = '$userID') AND rents.id = $rentID");

    $startDate = new DateTime($car['startDate']);
    $endDate = clone $startDate;
    $endDate->add(date_interval_create_from_date_string($car['duration'] . ' days'));
    
    $car['startDate'] = $startDate->format('d/m/Y');
    $car['endDate'] = $endDate->format('d/m/Y');
    
    $car['price'] *= $car['duration']; 
    $car['duration'] .= (' day' . (intval($car['duration']) > 1 ? 's' : ''));
    $car['rent_id'] = $rentID;
    
    $car['qr_code'] = Token::encode([
      'rent' => $rentID
    ], getenv('TOKEN_KEY'));;
    
    $car['error'] = $queryRes;
  
  } catch (NotFoundException $e) {
    $queryRes = $user->isAdmin() ? 'You cannot open this page as this is not a rent of yours' : 'We haven\'t found this rent in our database, contact our client service';
    $useStatic = true;
  }
  $car['error'] = "<p class='server_message error_el'>$queryRes</p>";

  $page->putDynamicContent($car);
}

$page->putDynamicContent([
  'error' => ''
]);

$page->useStatic($useStatic);

$db->close();
$page->render();

unset($_SESSION['rent']);
unset($_SESSION['car_id']);

?>
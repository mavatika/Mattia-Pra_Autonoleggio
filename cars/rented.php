<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Token.php');
$user = new User();
$db = new Database();

// if ($user->loggedIn && empty($_GET['rent'])) {
//   header('Location:/user');
//   exit;
// }

if (empty($_GET['rent']) && !empty($_SESSION['temp_user'])) unset($_SESSION['temp_user']);

$useStatic = (!$user->loggedIn && empty($_SESSION['temp_user']) && empty($_GET['email'])) || empty($_GET['rent']);
$page = new Template('rented', null, false);

// echo "\nLOGGED IN: " . ($user->loggedIn ? 'TRUE' : 'FALSE');
// echo "\nSESSION: " . (!empty($_SESSION['temp_user']) ? 'TRUE' : 'FALSE');
// echo "\nEMAIL: " . (!empty($_GET['email']) ? 'TRUE' : 'FALSE');
// echo "\nRENT: " . (!empty($_GET['rent']) ? 'TRUE' : 'FALSE');

$userData = [];
if ($user->loggedIn) $userData = $user->getUser();

$page->putDynamicContent(array_merge($userData, [
  'should_ask_email' => empty($_GET['rent']) && !$user->loggedIn && empty($_SESSION['temp_user']) ? '<div class="input_wrapper">
            <label for="email">Type the email you used to rent the car</label>
            <input type="email" name="email" id="email" autocomplete="email" placeholder="mario.rossi@dominio.it" required>
          </div>' : ''
]));

if (
      ($user->loggedIn || 
        (!$user->loggedIn && 
          (!empty($_SESSION['temp_user']) || !empty($_GET['email']))
        )
      ) && !empty($_GET['rent'])
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
      'cars.brand, cars.model, cars.price, cars.img1, cars.id as car_id, cities.name as city, cities.address, rents.startDate, rents.duration, rents.id as rent_id',
      'cars, cities, rents',
      "WHERE cars.id = rents.car_id AND cities.code = rents.city AND rents.user_id = '$userID' AND rents.id = '". $_GET['rent'] ."'");

    $startDate = new DateTime($car['startDate']);
    $endDate = clone $startDate;
    $endDate->add(date_interval_create_from_date_string($car['duration'] . ' days'));
    
    $car['startDate'] = $startDate->format('d/m/Y');
    $car['endDate'] = $endDate->format('d/m/Y');
    
    $car['price'] *= $car['duration']; 
    $car['duration'] .= (' day' . (intval($car['duration']) > 1 ? 's' : ''));
    
    $car['qr_code'] = Token::encode([
      'rent' => $_GET['rent']
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

?>
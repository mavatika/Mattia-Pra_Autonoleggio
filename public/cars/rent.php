<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/city_list.php');

$user = new User();

$page = new Template('rent', !$user->loggedIn);
$db = new Database();

if (count($_POST) > 0) {
  // RICHIAMATO SE STESSO
  $pms = ['city', 'startDate', 'duration', 'readterm'];
  if(!$user->loggedIn) array_push($pms, 'name', 'surname', 'email', 'bday');
  $params = Utils::checkParams($pms);

  $errs = '';

  if (count($params) == 0) {
    try {
      if (!$user->loggedIn) {
        $bday = new DateTime($_REQUEST['bday']);
        $now = new DateTime();
        $age = $now->diff($bday)->y;
        $userData = User::createTemp($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['email'], $age);
        $_SESSION['temp_user'] = $userData['username'];
      } else {
        $userData = $user->getUser();
      }

      $startDate = new DateTime($_REQUEST['startDate']);

      // Il controllo sul $_REQUEST['car'] serve a verificare che l'utente non abbia voluto cambiare la macchina all'ultimo premendo il Reset del form
      $carID = isset($_REQUEST['car']) ? $_REQUEST['car'] : $_SESSION['car_id'];
      if (empty($carID)) throw new Error('CAR ID EMPTY');

      $rent = [
        'car_id' => $carID,
        'user_id' => $userData['username'],
        'city' => $_REQUEST['city'],
        'startDate' => $startDate->format('Y-m-d'),
        'duration' => $_REQUEST['duration']
      ];

      $response = $db->update([
        'quantity' => 'GREATEST(0, quantity - 1)'
      ], 'stock', "car_id = $carID");

      if (!$user->loggedIn && ($response == 'not-found' || $response == 'update-not-needed')) $db->delete('users', "username = '" . $userData['username'] . "'");
      
      if ($response == 'not-found') $errs .= '<p class="server_message error_el">We haven\'t found this car in our database</p>'."\n";
      if ($response == 'update-not-needed') $errs .= '<p class="server_message error_el">This car is not available in this moment, try again later</p>'."\n";
      if ($response == 'success') {
        $_SESSION['rent'] = $db->put($rent, 'rents');
        unset($_SESSION['car_id']);
        header("Location:/cars/rented.php");
        exit;
      }
    } catch (Exception $e) { $errs .= '<p class="server_message error_el">'.$e.'</p>'."\n"; }
  } else {
    foreach ($params as $el) {
      $errs .= '
          <p class="server_message error_el">
            '.ucfirst($el).' value is missing, please fill it.
          </p>'."\n";
    }
  }
}

try {
  $where = !empty($_SESSION['car_id']) ? 'WHERE id = '. $_SESSION['car_id'] : 'LIMIT 1';
  $car = $db->get('id, brand, model, image', 'cars', $where);
} catch (Exception $e) {
  header('Location:'.$_SERVER['REQUEST_URI']);
}

$d = [
  'errors' => !empty($errs) > 0 ? $errs : '',
  'cities' => getCities($db), 
  'cars' => getCars($db, $car['id']),
  'carDisabled' => !empty($_SESSION['car_id']) ? 'disabled = "true"' : ''
];

$d = array_merge($d, $car);
if ($user->loggedIn) $d = array_merge($d, $user->getUser());
else {
  foreach (['name', 'surname', 'bday', 'email'] as $s) {
    $d[$s] = '';
  }
}

$db->close();
$page->putDynamicContent($d);
$page->render();

?>
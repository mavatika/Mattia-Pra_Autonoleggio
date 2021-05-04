<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/city_list.php');

$user = new User();

$page = new Template('rent', !$user->loggedIn);
$db = new Database();

if (count($_POST) > 0) {
  // RICHIAMATO SE STESSO
  $pms = ['car', 'city', 'startDate', 'duration', 'readterm'];
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
        $_SESSION['temp_user'] = $_REQUEST['email'];
      } else {
        $userData = $user->getUser();
      }

      $startDate = new DateTime($_REQUEST['startDate']);
      
      $rent = [
        'car_id' => $_REQUEST['car'],
        'user_id' => $userData['username'],
        'city' => $_REQUEST['city'],
        'startDate' => $startDate->format('Y-m-d'),
        'duration' => $_REQUEST['duration']
      ];

      $response = $db->update([
        'quantity' => 'GREATEST(0, quantity - 1)'
      ], 'stock', 'car_id = '.$_REQUEST['car']);
      
      if ($response == 'not-found') $errs .= '<p class="server_message error_el">We haven\'t found this car in our database</p>'."\n";
      if ($response == 'update-not-needed') $errs .= '<p class="server_message error_el">This car is not available in this moment, try again later</p>'."\n";
      if ($response == 'success') {
        $id = $db->put($rent, 'rents');
        header("Location:/cars/rented.php?rent=$id");
        exit;
      }
    } catch (Exception $e) { $errs .= '<p class="server_message error_el">An error occured, try again</p>'."\n"; }
  } else {
    foreach ($params as $el) {
      $errs .= '
          <p class="server_message error_el">
            '.$el.' value is missing, please fill it.
          </p>'."\n";
    }
  }
}

try {
  $where = !empty($_GET['id']) ? 'WHERE id = '. $_GET['id'] : 'LIMIT 1';
  $car = $db->get('id, brand, model, image', 'cars', $where);
} catch (Exception $e) {
  header('Location:'.$_SERVER['REQUEST_URI']);
}

$d = [
  'errors' => !empty($errs) > 0 ? $errs : '',
  'cities' => getCities($db, !empty($_GET['where']) ? $_GET['where'] : null), 
  'cars' => getCars($db, $car['id']),
  'carDisabled' => !empty($_GET['id']) ? 'disabled = "true"' : '',
  'hiddenCar' => !empty($_GET['id']) ? "<input type='hidden' name='car' value='".$_GET['id']."'>" : ''
];

$d = array_merge($d, $car);
if ($user->loggedIn) $d = array_merge($d, $user->getUser());

$db->close();
$page->putDynamicContent($d);
$page->render();

?>
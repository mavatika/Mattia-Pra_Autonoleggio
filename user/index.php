<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/require.php');

$user = new User();

if(!$user->loggedIn) {
  header("Location: /user/login.php?to=/user");
  exit;
}

$db = new Database();
$temp = [];

if (count($_POST) > 0) {
  if (isset($_POST['updateuser'])) {
    try {
      $user->update($_POST['city'], $_POST['fav_car']);
      $temp['user_update'] = '<p class="server_message success_el">User updated successfully</p>';
    } catch (Exception $e) {
      $temp['user_update'] = '<p class="server_message error_el">User update failed</p>';
    }
  } else if ($user->isAdmin() && isset($_POST['create_sth'])) {
    if ($_POST['create_sth'] == 'adduser') {
      $created = User::signup($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['surname'], $_POST['age'], $_POST['city'], $_POST['fav_car'], $_POST['scope']);
      $temp['user_add'] = $created === true ? 
        '<p class="server_message success_el">User created</p>' : 
        "<p class='server_message error_el'>$created</p>";
    } else if ($_POST['create_sth'] == 'addcar') {
      try {
        $cc = [];
        if (!empty($_FILES['image'])) {
          $d = '/img/pages/cars/cars/';
          $cc['image'] = $d . Template::writeImageToDir($_FILES['image'], $d);
        }
        foreach ($_POST as $column => $value) {
          if (in_array($column, ['brand', 'model', 'price', 'engine', 'seats', 'transmission', 'short_description', 'category', 'speed', 'gps', 'tank', 'description', 'img1', 'img2', 'img3', 'age']))
            $cc[$column] = $value;
        }
        $car_id = $db->put($cc, 'cars');
        if ($car_id) {
          $db->put([
            'car_id' => $car_id,
            'quantity' => $_POST['stock']
          ], 'stock');
          $temp['car_add'] = '<p class="server_message success_el">Car created successfully</p>';
        } else $temp['car_add'] =  "<p class='server_message error_el'>$car_id</p>";
      } catch (Exception $e) {
        echo $e;
        $temp['car_add'] = "<p class='server_message error_el'>".$e->getMessage()."</p>";
      }
    }
  }
}

$userData = $user->getFullUser();

$userData['rents_update'] = ''; // Messaggi tabella prenotazioni
$userData['user_update'] = !empty($temp['user_update']) ? $temp['user_update'] : ''; // Messaggi tabella aggiornamento utente

$userData['cars_update'] = !empty($temp['car_add']) ? $temp['car_add'] : ''; // Messaggi tabella macchine --> solo admin
$userData['users_list_update'] = !empty($temp['user_add']) ? $temp['user_add'] : ''; // Messaggi tabella utenti --> solo admin
$userData['message_update'] = '';

unset($temp);

if (!empty($_GET['canc'])) {
  try {
    $car_id = $db->get('car_id', 'rents', "where id = '".$_GET['canc']."'")['car_id'];
    $adminQuery = !$user->isAdmin() ? "user_id ='".$userData['username']."' AND " : '';
    $db->delete('rents',  $adminQuery . "id = '".$_GET['canc']."'");
    $db->update([
      'quantity' => 'quantity + 1'
    ], 'stock', "car_id = '$car_id'");
    $userData['rents_update'] = '<p class="server_message success_el">Rent deleted successfully</p>';
  } catch (Exception $e) {
    $userData['rents_update'] = '<p class="server_message error_el">Rent delete failed</p>';
  }
}

if ($user->isAdmin()) {
  $brands_in_db = $db->get('DISTINCT brand', 'cars');
  $userData['brands_in_db'] = '';

  foreach ($brands_in_db as $b => $brand) {
    $userData['brands_in_db'] .= "<option value='".$brand['brand']."'>\n";
  }

  try {
    if (!empty($_GET['deleteuser'])) {
      $db->delete('users', "username = '".$_GET['deleteuser']."'");
      $userData['users_list_update'] = '<p class="server_message success_el">User removed successfully</p>';
    }
  } catch (NotFoundException $e) {
    $userData['users_list_update'] = '<p class="server_message warning_el">User to be removed not found</p>';
  } catch (Exception $e) {
    $userData['users_list_update'] = '<p class="server_message error_el">User remove failed</p>';
  }
  try {
    if (isset($_GET['markcomplete'])) {
      $response = $db->update([
        'answered' => 1,
      ], 'messages', "id = '".$_GET['markcomplete']."'");
      
      if ($response == 'update-not-needed') $userData['message_update'] = '<p class="server_message warning_el">This messages has been already marked as answered</p>';
      if ($response == 'success') $userData['message_update'] = '<p class="server_message success_el">Message marked as answered successfully</p>';
    }
  } catch (NotFoundException $e) {
    $userData['message_update'] = '<p class="server_message warning_el">Message to be updated not found</p>';
  } catch (Exception $e) {
    $userData['message_update'] = '<p class="server_message warning_el">Message update failed</p>';
  }

  try {
    if (!empty($_GET['carquantity']) && !empty($_GET['q'])) {
      $plus = intval($_GET['q']) > 0 ? '+ 1' : '- 1';
      $response = $db->update([
        'quantity' => "GREATEST(0, quantity $plus)",
      ], 'stock', "car_id = '".$_GET['carquantity']."'");
      
      if ($response == 'update-not-needed') $userData['cars_update'] = '<p class="server_message warning_el">We cannot have less than 0 vehicles, remove the entire car instead</p>';
      if ($response == 'success') $userData['cars_update'] = '<p class="server_message success_el">Car updated successfully</p>';
    }
    if (!empty($_GET['delete'])) {
      $db->delete('cars', 'id = '.$_GET['delete']."'");
      $userData['cars_update'] = '<p class="server_message success_el">Car removed successfully</p>';
    }
  } catch (NotFoundException $e) {
    $userData['cars_update'] = '<p class="server_message error_el">We haven\'t found this car in our database</p>';
  } catch (Exception $e) {
    $userData['cars_update'] = '<p class="server_message error_el">Car update failed</p>';
  }
  
}

$page = new Template($user->isAdmin() ? 'admin' : 'user', false);

require_once($_SERVER['DOCUMENT_ROOT'].'/src/components/my_rents.php');

$rents = getRents($user->isAdmin() ? null : $userData['username']);

$db->close();

$page->putDynamicContent(array_merge($userData, [
  'user_list' => $user->isAdmin() ? getUsersList() : '',
  'stock' => $user->isAdmin() ? getAdminCars() : '',
  'message_list' => $user->isAdmin() ? getMessages() : '',
  'rents' => $rents
]));

$page->render();


?>
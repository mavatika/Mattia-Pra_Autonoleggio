<?php
function getRents ($user = null) {
  $temp = '';
  try {
    $db = new Database();

    $rents = $user ? 
      $db->get(
        'rents.id as rentId, cars.brand, cars.model, cities.name as city, rents.startDate, rents.duration, cars.price',
        'cars, cities, rents',
        'WHERE cars.id = rents.car_id AND cities.code = rents.city AND rents.user_id = "'.$user.'"') : 
      $db->get(
        'rents.id as rentId, users.username, users.name, users.surname, users.age, cars.brand, cars.model, cities.name as city, rents.startDate, rents.duration, cars.price',
        'cars, cities, users, rents',
        'WHERE cars.id = rents.car_id AND cities.code = rents.city AND users.username = rents.user_id');

    if(isAssoc($rents)) $rents = [$rents];

    foreach ($rents as $rent) {
      $startDate = new DateTime($rent['startDate']);
      $endDate = clone $startDate;
      $endDate->add(date_interval_create_from_date_string($rent['duration'] . ' days'));
      $price = $rent['price'] * $rent['duration'];
      
      $temp .= '<tr data-rentid="'.$rent['rentId'].'">';

      if (!$user) {
        $temp .= '<td>'.$rent['username'].'</td>
        <td>'.$rent['name'].'</td>
        <td>'.$rent['surname'].'</td>
        <td>'.$rent['age'].'</td>';
      }

      $temp .= 
        '<td>'.$rent['brand'].'</td>
          <td>'.$rent['model'].'</td>
          <td>'.$rent['city'].'</td>
          <td>'.$startDate->format('d/m/Y').'</td>
          <td>'.$endDate->format('d/m/Y').'</td>
          <td>'.$price.' €</td>
          <td>
            <a href="/user/index.php?canc='.$rent['rentId'].'" class="cancel icon_wrapper" title="Cancel rent">
              <img src="/img/icons/x.svg" alt="" role="presentation">
            </a>
          </td>
        </tr>'."\n";
    }
    $db->close();
  } catch (NotFoundException $e) {
    $temp = errorLine(
      $user ? 7 : 11, 
      $user ? 
        '<p>You haven\'t rented any car yet</p>
          <a href="/cars" title="Go to the cars list"><span class="bold">Do it now!</span></a>' :
        '<p>There are no rents yet, try to come back later!</p>'
      );
  } catch (Exception $e) {
    $temp = errorLine($user ? 7 : 11, '<p>An error occured while fetching the rents</p>');
  }
  return $temp;
}

function getAdminCars() {
  $temp = '';
  try {
    $db = new Database();

    $cars = $db->get('cars.id as car_id, cars.brand, cars.model, cars.age, stock.quantity', 'cars, stock', 'WHERE cars.id = stock.car_id ORDER BY cars.brand');

    if(isAssoc($cars)) $cars = [$cars];
    foreach ($cars as $car) {
      $temp .= 
        '<tr>
          <td>'.$car['brand'].'</td>
          <td>'.$car['model'].'</td>
          <td>'.$car['age'].'</td>
          <td>
            <a '. ($car['quantity'] > 0 ? 'href="/user/index.php?carquantity='.$car['car_id'].'&q=-1"' : 'disabled') .' class="set_quantity icon_wrapper" title="Decrease">
              -
            </a>
            <span>'.$car['quantity'].'</span>
            <a href="/user/index.php?carquantity='.$car['car_id'].'&q=1" class="set_quantity icon_wrapper" title="Increase">
              +
            </a>
          </td>
          <td>
            <a href="/user/index.php?delete='.$car['car_id'].'" class="cancel icon_wrapper" title="Remove car">
              <img src="/img/icons/x.svg" alt="" role="presentation">
            </a>
          </td>
        </tr>'."\n";
    }
    $db->close();
  } catch (NotFoundException $e) {
    $temp = errorLine(5, '<p>There are no cars in our database, add one to get started!</p>');
  } catch (Exception $e) {
    $temp = errorLine(5, '<p>An error occured while fetching the cars</p>');
  }
  return $temp;
}

function getUsersList() {
  $temp = '';
  try {
    $db = new Database();

    $users = $db->get('username, name, surname, scope, age, city, fav_car', 'users', 'order by scope asc, username asc, surname asc, name asc, age asc');

    if(isAssoc($users)) $users = [$users];
    foreach ($users as $user) {
      $temp .= 
        '<tr>
          <td>'.$user['username'].'</td>
          <td>'.$user['surname'].'</td>
          <td>'.$user['name'].'</td>
          <td>'.$user['age'].'</td>
          <td>'.$user['scope'].'</td>
          <td>'.(empty($user['city']) ? '-' : $user['city']).'</td>
          <td>'.(empty($user['fav_car']) ? '-' : $user['fav_car']).'</td>
          <td>
            <a href="/user/index.php?deleteuser='.$user['username'].'" class="cancel icon_wrapper" title="Remove user">
              <img src="/img/icons/x.svg" alt="" role="presentation">
            </a>
          </td>
        </tr>'."\n";
    }
    $db->close();
  } catch (NotFoundException $e) {
    $temp = errorLine(8, '<p>There are no users in our database, add one to get started!</p>');
  } catch (Exception $e) {
    $temp = errorLine(8, '<p>An error occured while fetching the users list</p>');
  }
  return $temp;
}

function getMessages() {
  $temp = '';
  try {
    $db = new Database();

    $messages = $db->get('messages.id as msg_id, users.username, users.name, users.surname, users.email, messages.message, messages.object', 'users, messages', 'where users.username = messages.user_id and messages.answered = 0');

    if(isAssoc($messages)) $messages = [$messages];
    foreach ($messages as $msg) {
      $temp .= 
        '<tr class="message_row" data-id="'.$msg['msg_id'].'" data-message="'.$msg['message'].'" data-subject="'.$msg['name'].' '.$msg['surname'].'"'. (!empty($msg['object']) ? 'data-object="'.$msg['object'].'"' : '') .'>
          <template>'.$msg['message'].'</template>
          <td title="'.$msg['username'].'">'.$msg['username'].'</td>
          <td>'.(!empty($msg['object']) ? $msg['object'] : $msg['message']).'</td>
          <td>
            <a href="mailto:'.$msg['email'].'?subject=RE:%20'.$msg['object'].'" class="cancel icon_wrapper" title="Reply">
              <img src="/img/icons/reply.svg" alt="" role="presentation">
            </a>
          </td>
        </tr>'."\n";
    }
    $db->close();
  } catch (NotFoundException $e) {
    $temp = errorLine(3, '<p>There are no messages in the inbox</p>');
  } catch (Exception $e) {
    echo $e;
    $temp = errorLine(3, '<p>An error occured while fetching the messages</p>');
  }
  return $temp;
}

function errorLine($colspan, $inner) {
  return '
    <tr class="notHoverable">
      <td colspan="'.$colspan.'">
        '.$inner.'
      </td>
    </tr>';
}

?>
<?php
function getCities($db = null, $selected = null) {
  $toClose = $db == null;
  if (!$db) $db = new Database();

  $cities = $db->get('code, name', 'cities', 'order by name');
  $c = '';
  foreach($cities as $city) {
    $c .=  "\t\t\t\t\t\t" . '<option value="' . $city['code'] . '" '. ($city['code'] == $selected ? 'selected' : '') .' >' . $city['name'] . '</option>' . "\n";
  }

  if($toClose) $db->close();

  return $c;
}

function getCars($db = null, $carId) {
  $toClose = $db == null;
  if (!$db) $db = new Database();

  $cars = $db->get('id, brand, model, image', 'cars, stock', 'where cars.id = stock.car_id and stock.quantity > 0 order by brand, model');
  $c = '';


  $lastBrand = null;
  foreach($cars as $car) {
    $before = $lastBrand != null && $car['brand'] != $lastBrand ? "\t\t\t\t\t\t\t" . '</optgroup>' . "\n" : ''; 
    $before .= $car['brand'] != $lastBrand ? "\t\t\t\t\t\t\t" . '<optgroup label="' . $car['brand'] . '">' . "\n" : '';
    $isSelected = $carId == $car['id'] ? ' selected ' : '';
    $inner = "\t\t\t\t\t\t\t\t".'<option value="'.$car['id'].'" data-image="'.$car['image'].'"'.$isSelected.'>'.$car['brand'].' '.$car['model'].'</option>' . "\n";    $c .=  ($before . $inner);
    $lastBrand = $car['brand'];
  }

  $c .= "\t\t\t\t\t\t\t" . '</optgroup>';

  if($toClose) $db->close();

  return $c;
}
?>
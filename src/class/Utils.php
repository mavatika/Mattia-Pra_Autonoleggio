<?php

final class Utils {
  public static function generateCityCode($city) {
    if (!empty($city)) {
      if (strlen($city) > 2) {
        $tmp_city = preg_split("/\s+/", $city);
        if (is_array($tmp_city) && count($tmp_city) > 1) {
          $city = '';
          foreach ($tmp_city as $char) {
            $city .= $char[0];
          }
        }
        $city = substr($city, 0, 2);
      }
      $city = strtoupper($city);
    }
    return $city;
  }

  public static function checkParams(array $p) {
    $found = [];
    foreach ($p as $e) {
      if (empty($_REQUEST[$e])) {
        array_push($found, $e);
      }
    }
    return $found;
  }

  public static function isAssoc($arr) {
    if (!is_array($arr) || array() == $arr) return false;
    return array_keys($arr) != range(0, count($arr) - 1);
  }

  public static function getRequestDeepness() {
    return substr_count(str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']), '/');
  }

  public static function deleteCookie(string $name) {
    if (isset($_COOKIE[$name])) {
      setcookie($name, '', 1, $GLOBALS['PROJECT_FOLDER']);
      unset($_COOKIE[$name]);
    }
  }

}

?>
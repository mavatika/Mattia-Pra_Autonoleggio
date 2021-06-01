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

  public static function writeImageToDir($file, string $dir) {
    if (ini_get('file_uploads') != 1) throw new DieProgramException('Your <i>php.ini</i> doesn\'t allow files upload, please fix it');
    $dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
    if (!is_writable($dir)) throw new DieProgramException('Your upload folder doesn\'t have write permissions');
    $filename = md5(basename($file['name'])) . '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $target = $dir . $filename;
    $check = getimagesize($file['tmp_name']); // tmp_name tiene il path temporaneo del file
    if ($check === false || !in_array($check['mime'], ['image/png', 'image/gif', 'image/bpm', 'image/tiff', 'image/svg+xml'])) throw new FileUploadException('File not an image with transparent background');
    if (file_exists($target)) return $filename;
    if ($file['size'] > 20 * 1024 * 1024) throw new FileUploadException('Image is too big');

    if (move_uploaded_file($file['tmp_name'], $target)) return $filename;
    else throw new FileUploadException();
  }

}

?>
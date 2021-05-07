<?php

if (isset($_SERVER['DOCUMENT_ROOT'])) {
  require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Template.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Utils.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Errors.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/User.php');

  require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/env.php');

  require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Database.php');
} else {
  echo "<h1 style='text-align:center;'>DOCUMENT ROOT IS MISCONFIGURED</h1>";
}

?>
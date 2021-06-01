<?php

$fp = @fopen($_SERVER['DOCUMENT_ROOT'].'/.env', 'r');

if ($fp) {
  while (($line = fgets($fp)) != false) {
    $trimmed = trim($line);
    if (strlen($trimmed) > 0 && $trimmed[0] != '#') putenv($trimmed);
  }
  fclose($fp);
} else throw new Exception('Unable to open .ENV file');

?>
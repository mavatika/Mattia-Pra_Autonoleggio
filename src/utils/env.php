<?php

$fp = @fopen($_SERVER['DOCUMENT_ROOT'].'/.env', 'r');

if ($fp) {
  while (($line = fgets($fp)) != false) {
    if (strlen($line) > 0 && $line[0] != '#') putenv(preg_replace('/\s+/', '', $line));
  }
  fclose($fp);
} else throw new Exception('Unable to open .ENV file');

?>
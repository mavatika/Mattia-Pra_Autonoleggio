<?php

$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/.env', 'r');

if ($fp) {
  while (($line = fgets($fp)) != false) {
    putenv(trim($line));
  }  
  fclose($fp);
} else throw new DieProgramException('Unable to open .ENV file');

?>
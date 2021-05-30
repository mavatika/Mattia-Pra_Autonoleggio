<?php
function shutDownFunction() {
  $err = error_get_last();
  if ($err['type'] === 64) {
    echo '
      <div style="text-align:center;font-family:sans-serif;padding-top:45px;">
        <h1>
          Qualcosa è andato storto con gli import dei file, questo significa che la root del progetto è mal configurata
        </h1>
        <h3>
          Per risolvere consulta il file situato in "~/src/utils/require.php"
        </h3>
        <p style="margin-top:30px;">
          <strong>L\'errore è stato generato da:</strong>
          <br>'.$err['message'].'<br><br>
          <strong>Ed è stato generato in:</strong>
          <br>'.$err['file'].'<br><strong>Linea:</strong> '.$err['line'].'
        </p>
      </div>
    ';
  }
}
register_shutdown_function('shutDownFunction');

/*
 * Il valore di $GLOBALS['PROJECT_FOLDER'] va impostato al path della cartella contenente il progetto
 * '/' oppure '' --> progetto esploso nella root del server
*/

$GLOBALS['PROJECT_FOLDER'] = '/Pra';

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['PROJECT_FOLDER'] . (substr($GLOBALS['PROJECT_FOLDER'], -1) != '/' ? '/' : '');

@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Template.php');
@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Utils.php');
@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Errors.php');
@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/User.php');

@require_once($_SERVER['DOCUMENT_ROOT'].'/src/utils/env.php');

@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Database.php');
@require_once($_SERVER['DOCUMENT_ROOT'].'/src/class/Token.php');

?>
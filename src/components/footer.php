<?php

$deepness = str_repeat('../', Utils::getRequestDeepness());

return [
  'template' => '
    <footer>
      <div class="copyright">
        <p>Copyright © 2021 - Mattia Prà Autonoleggio S.p.A. | All rights reserved | <a class="normal_link" href="'.$deepness.'privacy.php">Privacy Policy</a></p>
        <p>P.IVA 67737800432</p>
      </div>
      '. (!empty($_SESSION['user']) ? '<p>
      <a href="'.$deepness.'user/logout.php">Log out</a>
    </p>' : '') .'
    </footer>',
  'head' => '<link rel="stylesheet" href="'.$deepness.'css/components/_footer.css">'
]
?>
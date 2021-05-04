<?php

return [
  'template' => '
    <footer>
      <div class="copyright">
        <p>Copyright © 2021 - Mattia Prà Autonoleggio S.p.A. | All rights reserved | <a class="normal_link" href="/privacy.php">Privacy Policy</a></p>
        <p>P.IVA 67737800432</p>
      </div>
      '. (!empty($_SESSION['user']) ? '<p>
      <a href="/user/logout.php">Log out</a>
    </p>' : '') .'
    </footer>',
  'head' => '<link rel="stylesheet" href="/public/css/components/_footer.css">'
]
?>
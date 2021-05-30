<?php

$p = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);

if ($p == 'index.php') $p = '/';
if ($p == 'cars/index.php') $p = '/cars';
if ($p == 'user/' || $p == 'user/index.php') $p = '/user';

$deepness = str_repeat('../', Utils::getRequestDeepness());

$userLogged = empty($_SESSION['user']) ? 
  '<a href="'.$deepness.'user/login.php">LOGIN</a>' :
  ($p != '/user' ? '<a href="'.$deepness.'user" title="Go to the account page">{ name } { surname }</a>' : '<a href="'.$deepness.'user/logout.php" title="Log out">Logout</a>');

return [
  'template' => '<header>
    <div class="logo" aria-roledescription="logo link">
      <a href="'.$_SERVER['DOCUMENT_ROOT'].'"><img src="'.$deepness.'img/common/logo.png" alt="Go to the homepage" height="80"></a>
    </div>
    <div class="hamburger" tabindex="0" role="button">
      <div class="hamburger_inner"></div>
    </div>
    <nav>
      <ul role="menubar" aria-label="Navigation bar">
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/' ? ' active_link' : '') . '" href="'.$deepness.'index.php">Home</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/cars' ? ' active_link' : '') . '" href="'.$deepness.'cars/">Our cars</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == 'about.php' ? ' active_link' : '') . '" href="'.$deepness.'about.php">Our history</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == 'contact.php' ? ' active_link' : '') . '" href="'.$deepness.'contact.php">Contact us</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == 'cars/rented.php' ? ' active_link' : '') . '" href="'.$deepness.'cars/rented.php?source=header">Find rent</a></li>
        <li role="none">'.$userLogged.'</li>
      </ul>
    </nav>
  </header>',
  'head' => '<link rel="stylesheet" href="'.$deepness.'css/components/_header.css">'
];
?>
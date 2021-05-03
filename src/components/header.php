<?php

$p = strtok($_SERVER["REQUEST_URI"], '?');
if ($p == '/index.php') $p = '/';
if ($p == '/user/' || $p == '/user/index.php') $p = '/user';

$userLogged = empty($_SESSION['user']) ? 
  '<a href="/user/login.php">LOGIN</a>' :
  ($p != '/user' ? '<a href="/user" title="Go to the account page">{ name } { surname }</a>' : '<a href="/user/logout.php" title="Log out">Logout</a>');

return [
  'template' => '<header>
    <div class="logo" aria-roledescription="logo link">
      <a href="/"><img src="/img/common/logo.png" alt="Go to the homepage" height="80"></a>
    </div>
    <div class="hamburger" tabindex="0" role="button">
      <div class="hamburger_inner"></div>
    </div>
    <nav>
      <ul role="menubar" aria-label="Navigation bar">
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/' ? ' active_link' : '') . '" href="/">Home</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/cars/' ? ' active_link' : '') . '" href="/cars">Our cars</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/about.php' ? ' active_link' : '') . '" href="/about.php">Our history</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/contact.php' ? ' active_link' : '') . '" href="/contact.php">Contact us</a></li>
        <li role="none"><a role="menuitem" class="header_link' . ($p == '/cars/rented.php' ? ' active_link' : '') . '" href="/cars/rented.php">Find rent</a></li>
        <li role="none">'.$userLogged.'</li>
      </ul>
    </nav>
  </header>',
  'head' => '<link rel="stylesheet" href="/public/css/components/_header.css">'
];
?>
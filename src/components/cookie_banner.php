<?php

$deepness = str_repeat('../', Utils::getRequestDeepness());

return [
    'template' => 
        '<div class="cookies" role="banner">
            <button class="close" tabindex="0" title="Close banner">
                <img src="'.$deepness.'img/icons/x.svg" alt="" role="presentation">
            </button>
            <div class="cookies_img" role="presentation">
                <img src="'.$deepness.'img/common/cookies.svg" alt="" width="45">
            </div>
            <h3>Cookies</h3>
            <p>
                This website uses cookies and you accept the use of them by using it.
                For more informations visit our <a href="'.$deepness.'privacy.php" title="Go to the Privacy Policy page">Cookies Policy</a>
            </p>
        </div>',
    'head' => '<link rel="stylesheet" href="'.$deepness.'css/components/_cookie_banner.css">'
]

?>
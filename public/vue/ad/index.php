<?php
// Redirect directory access to the SPA login URL to avoid "Not Found" on servers
http_response_code(302);
header('Location: /vue/ad/login');
exit;

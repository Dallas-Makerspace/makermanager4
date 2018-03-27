<?php

Router::prefix('api', function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->resources('Meberships');
});

?>

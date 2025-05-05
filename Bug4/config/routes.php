<?php

use Slim\App;

return function (App $app) {
    $app->get('/', [\App\Controllers\Posts::class, 'landingPage']);
    $app->get('/posts', [\App\Controllers\Posts::class, 'fetchPosts']);
};

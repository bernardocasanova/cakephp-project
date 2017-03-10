<?php
App::uses('Radio', 'Model');

$Radio  = new Radio();
$host   = env("HTTP_HOST");
$domain = Configure::read('radios.domain');

if ($host == $domain) {
    Router::connect(
        '/',
        array('controller' => 'users', 'action' => 'index', 'admin' => true)
    );
} else {
    $slug = $Radio->getSlugByHost($host, $domain);
    //mobile views
    Router::connect(
        '/mobile',
        array('controller' => 'pages', 'action' => 'home_mobile', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/',
        array('controller' => 'pages', 'action' => 'home', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/edit',
        array('controller' => 'pages', 'action' => 'live_edit', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/color',
        array('controller' => 'pages', 'action' => 'update_main_color', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/new-schedule',
        array('controller' => 'pages', 'action' => 'add_schedule', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/send-message',
        array('controller' => 'contacts', 'action' => 'send', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/new-participant',
        array('controller' => 'participants', 'action' => 'add', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/login',
        array('controller' => 'radios_users', 'action' => 'login', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/attempt',
        array('controller' => 'radios_users', 'action' => 'attempt', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/logout',
        array('controller' => 'radios_users', 'action' => 'logout', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/:controller',
        array('action' => 'index', 'plugin' => 'radio', 'radioSlug' => $slug)
    );

    Router::connect(
        '/:controller/:action/*',
        array('plugin' => 'radio', 'radioSlug' => $slug)
    );
}

Router::parseExtensions('json');

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
// CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';

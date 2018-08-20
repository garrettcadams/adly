<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

if (!is_app_installed()) {
    Router::connect('/install/:action', array('controller' => 'Install'));
    if (strpos(env('REQUEST_URI'), 'install') === false) {
        return Router::redirect('/**', ['controller' => 'Install', 'action' => 'index'], ['status' => 307]);
    }
}

Router::scope('/', function (RouteBuilder $routes) {
    /*
    if (!is_app_installed()) {
        $request = Router::getRequest();

        if (strpos($request->url, 'install') === false) {
            $routes->connect('/install/:action', ['controller' => 'Install']);
            return $routes->redirect('/**', ['controller' => 'Install', 'action' => 'index'], ['status' => 307]);
        }
    }
    */

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);

    $routes->connect('/st/', ['controller' => 'Tools', 'action' => 'st']);

    $routes->connect('/api/', ['controller' => 'Tools', 'action' => 'api']);

    $routes->connect('/full/', ['controller' => 'Tools', 'action' => 'full']);

    $routes->connect('/bookmarklet/', ['controller' => 'Tools', 'action' => 'bookmarklet']);

    $routes->connect('/payment/ipn', ['controller' => 'Invoices', 'action' => 'ipn']);

    $routes->connect('/advertising-rates', ['controller' => 'Pages', 'action' => 'view', 'advertising-rates']);

    $routes->connect('/payout-rates', ['controller' => 'Pages', 'action' => 'view', 'payout-rates']);

    $routes->connect('/contact', ['controller' => 'Pages', 'action' => 'contact']);

    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'view']);

    $routes->connect('/blog', ['controller' => 'Posts', 'action' => 'index']);

    $routes->connect(
        '/blog/:id-:slug',
        ['controller' => 'Posts', 'action' => 'view'],
        ['pass' => ['id', 'slug'], 'id' => '[0-9]+']
    );

    $routes->connect('/ref/*', ['controller' => 'Users', 'action' => 'ref']);

    $routes->connect('/:alias/info', ['controller' => 'Statistics', 'action' => 'viewInfo'], ['pass' => ['alias']]);
    $routes->connect(
        '/:alias',
        ['controller' => 'Links', 'action' => 'view'],
        ['pass' => ['alias'], 'routeClass' => 'ShortLinkRoute']
    );

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Auth routes
 */
Router::prefix('auth', function (RouteBuilder $routes) {
    // All routes here will be prefixed with ‘/auth‘
    // And have the prefix => auth route element added.
    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);

    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);

    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

    $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);

    $routes->fallbacks('DashedRoute');
});

/**
 * Member routes
 */
Router::prefix('member', function (RouteBuilder $routes) {
    // All routes here will be prefixed with ‘/member‘
    // And have the prefix => member route element added.
    $routes->connect('/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);

    $routes->fallbacks('DashedRoute');
});


/**
 * Admin routes
 */
Router::prefix('admin', function (RouteBuilder $routes) {
    // All routes here will be prefixed with ‘/admin‘
    // And have the prefix => admin route element added.
    $routes->connect('/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);

    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();

<?php
/**
 * CakePHP PTA Plugin
 */

namespace Fr3nch13\Pta;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\PluginApplicationInterface;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * CakePHP PTA Plugin
 * @TODO Install https://github.com/dereuromark/cakephp-ide-helper So dependant projects can make use of this.
 */
class Plugin extends BasePlugin
{
    /**
     * Bootstraping for this specific plugin.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The app object.
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap($app);

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli($app);
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $app->addPlugin(\DebugKit\Plugin::class);
        }
    }

    /**
     * Add plugin specific routes here.
     *
     * @param object $routes The passed routes object.
     * @return void
     */
    public function routes($routes): void
    {
        // Add routes.
        Router::plugin(
            'Fr3nch13/Pta',
            ['path' => '/pta'],
            function (RouteBuilder $routes) {
                $routes->fallbacks(DashedRoute::class);
            }
        );

        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }

    /**
     * More bootstrapping if we're running on the command line.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The app object.
     * @return void
     */
    protected function bootstrapCli(PluginApplicationInterface $app)
    {
        try {
            $app->addPlugin('Bake');
            if (Configure::read('debug')) {
                $app->addPlugin('IdeHelper');
            }
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }
        // Load more plugins here
    }
}

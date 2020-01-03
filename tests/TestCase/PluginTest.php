<?php

/**
 * PluginTest
 */

namespace Fr3nch13\Pta\Test\TestCase;

use App\Application;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\RouteCollection;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * PluginTest class
 */
class PluginTest extends TestCase
{
    /**
     * Apparently this is the new Cake way to do integration.
     */
    use IntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap()
    {
        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
        $plugins = $app->getPlugins();

        $this->assertSame('Fr3nch13/Pta', $plugins->get('Fr3nch13/Pta')->getName());
        $this->assertEquals(Configure::read('Pta.test'), 'TEST');
    }

    /**
     * testRoutes
     *
     * @return void
     */
    public function testRoutes()
    {
        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
        $collection = new RouteCollection();
        $routeBuilder = new RouteBuilder($collection, '');
        $app->pluginRoutes($routeBuilder);
        $plugins = $app->getPlugins();

        $url = Router::url(['plugin' => 'Fr3nch13/Pta', 'controller' => 'App']);

        $this->assertEquals($url, '/pta/app');
    }
}

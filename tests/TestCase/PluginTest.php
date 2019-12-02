<?php

/**
 * PluginTest
 */

namespace Fr3nch13\Pta\Test\TestCase;

use App\Application;
use Cake\Console\CommandCollection;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Http\MiddlewareQueue;
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
     * The Application object.
     * @var \App\Application|null
     */
    public $App = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->App = new Application(CONFIG);
        $this->App->addPlugin('Fr3nch13/Pta');
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
        $plugin = Plugin::getCollection()->get('Fr3nch13/Pta');
        $plugin->bootstrap($this->App);

        // make sure it was able to read and store the config.
        $this->assertEquals(Configure::read('Pta.test'), 'TEST');
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $middleware = new MiddlewareQueue();
        $plugin = Plugin::getCollection()->get('Fr3nch13/Pta');
        $middleware = $plugin->middleware($middleware);

        $this->assertInstanceOf(MiddlewareQueue::class, $middleware);
    }

    /**
     * testRoutes
     *
     * @return void
     */
    public function testRoutes()
    {
        Router::resetRoutes();
        $collection = new RouteCollection();
        $routeBuilder = new RouteBuilder($collection, '');
        $plugin = Plugin::getCollection()->get('Fr3nch13/Pta');
        $plugin->routes($routeBuilder);

        $url = Router::url(['plugin' => 'Fr3nch13/Pta']);

        $this->assertEquals($url, '/pta');
    }
}

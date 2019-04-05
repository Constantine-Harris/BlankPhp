<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/11
 * Time: 21:39
 */

namespace App\Provider;


use Blankphp\Cache\Cache;
use Blankphp\Cache\RouteCache;
use Blankphp\Provider\Provider;

class RouteProvider extends Provider
{

    protected $namespace = 'App\Controllers';
    protected $route;

    public function boot()
    {
        $this->route = $this->app->make('route');
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }

    public function map()
    {
        $this->route->setNamespace($this->namespace);
        if ($this->route->getCache()){
            $this->mapWebRoute();
            $this->mapApiRoute();
        }
    }

    public function mapApiRoute()
    {
        $this->route
            ->GroupMiddleware('api')
            ->prefix('api')
            ->file(APP_PATH . 'routes/api.php');
    }


    public function mapWebRoute()
    {
        $this->route
            ->GroupMiddleware('web')
            ->file(APP_PATH . 'routes/web.php');
    }

}
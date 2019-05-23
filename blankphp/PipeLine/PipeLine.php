<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14
 * Time: 9:06
 */

namespace Blankphp\PipeLine;


use Blankphp\Contract\Container;

class PipeLine
{
    protected $app;
    protected $middleware;
    protected $request;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function send($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getAlice()
    {
        return function ($stack, $pipe) {
            return function () use ($stack, $pipe) {
                //做异常处理-  -中间件得生成对象,不采用静态方法,而是采用对象
                return $pipe::handle($this->request, $stack);
            };
        };
    }

    public function through($middleware)
    {
        //管道模式运行
        $this->middleware = is_array($middleware) ? $middleware : func_get_args();
        return $this;
    }

}
<?php
if (!function_exists('app')) {
    function app($abstract)
    {
        if (class_exists($abstract) || interface_exists($abstract) || !is_null(\Blankphp\Application::getInstance()->make($abstract)))
            return \Blankphp\Application::getInstance()->make($abstract);
        else
            return \Blankphp\Application::getInstance()->getSignal($abstract);
    }
}

if (!function_exists('config')) {
    function config($name, $default = null)
    {
        $descNames = explode('.', $name);
        $descNames=array_filter($descNames);
        try{
            $config=\Blankphp\Application::getInstance()->getSignal('config')[$descNames[0]];
            array_shift($descNames);
            foreach ($descNames as $descName){
                $config=$config[$descName];
            }
            return $config;
        }catch (Exception $exception){
            return $default;
        }
//        if (is_array($descName) && count($descName) > 1) {
//            $descName = array_flip($descName);
//            var_dump($descName);
////            var_dump(\Blankphp\App lication::getInstance()->getSignal('config')[$descName[0]]);
//        }
//        if (count($descName) > 1)
//            return \Blankphp\Application::getInstance()->getSignal('config')[$descName[0]];
//        return \Blankphp\Application::getInstance()->getSignal('config')[$name];
    }
}


if (!function_exists('view')) {
    function view($view = null, $data = [])
    {
        $factory = app(\Blankphp\Contract\View::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->view($view, $data);
    }
}

if (!function_exists('view_static')) {
    function view_static($view = null, $data = [], $time = 30000)
    {
        $factory = app('view.static');
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->view($view, $data, $time);
    }
}


if (!function_exists('url')) {
    function url($uri, $data = [])
    {
        //编译为目标地址
        $config = config('app.url');
        $url = $config . '/' . $uri;
        return $url;
    }
}

if (!function_exists('asset')) {
    function asset($uri, $data = [])
    {
        $url = config('app.url');
        $static = config('app.static');
        $url = $url . '/' . $static . '/' . $uri;
        return $url;
    }
}



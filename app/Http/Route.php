<?php



namespace App\Http;


class Route
{

    public static array $routes = [];

    public static function get($url, $handler)
    {
        $url = trim($url, '/');
        $url = $url === '' ? '/' : $url;
        self::$routes['get'][$url] = $handler;
    }

    public static function post($url, $handler)
    {
        $url = trim($url, '/');
        $url = $url === '' ? '/' : $url;
        self::$routes['post'][$url] = $handler;
    }

    public static function resolve(Request $request)
    {
        $method = $request->method();
        $url = $request->url();
        if (key_exists($method, self::$routes) && key_exists($url, self::$routes[$method])) {
            $handler = self::$routes[$method][$url];
            if (is_array($handler)) {
                $controller = array_shift($handler);
                $callback = array_shift($handler);
                $data =  call_user_func_array([new $controller, $callback], [$request]);
            } else {
                $data =  call_user_func_array($handler, [$request]);
            }

            echo $data;
        } else {
            echo "404 url not found! ";
        }
    }
}

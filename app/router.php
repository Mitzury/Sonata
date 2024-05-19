<?php
class Router
{
    protected $routes = [];
    protected $uri;
    protected $method;
    protected $route = [];

    public function __construct()
    {
        $this->uri = self::getRequestURI();
        $this->method = self::getRequestMethod();
    }

    private static function getRequestURI()
    {
        // Получаем строку запроса
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    private static function getRequestMethod()
    {
        if (!empty($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
        }
    }
    public function match()
    {
        foreach ($this->routes as $uriPattern)
            if ((preg_match("~^{$uriPattern['uri']}$~", $this->uri)) && ($uriPattern['method'] == $this->method)) {
                $this->route = $uriPattern;
                return true;
            }
    }
    public function run()
    {
        // Если маршрут найден
        if ($this->match()) {
            // Берем название контроллера и екшена
            $controller =  $this->route['controller'];
            $action =  $this->route['action'];
            // Получаем список параметров
            $segments = explode('/', $this->uri);
            array_shift($segments);
            $param = $segments;
            // Подключаем контроллер
            $controllerFile = '../app/controllers/' . $controller . 'Controller.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controller();
                if (!$param) {
                    $controller->$action();
                } else {
                    $param = $segments[0];
                    $controller->$action($param);
                }
            }
        } else {
            http_response_code(404);
            echo '404 not found';
        }
    }
    public function add($uri, $controller, $action, $method)
    {
        $this->routes[$uri] = [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }

    public function get($uri, $controller, $action)
    {
        $this->add($uri, $controller, $action, 'GET');
    }
    public function post($uri, $controller, $action)
    {
        $this->add($uri, $controller, $action, 'POST');
    }
}

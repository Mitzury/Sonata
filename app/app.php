<?php


class App {
    public static function run() {
        $router = new Router();
        $router->get('', 'Main', 'index');
        $router->get('news', 'News', 'index');
        $router->get('news/([0-9]+)', 'News', 'showById');
        $router->run();
    }
}
?>
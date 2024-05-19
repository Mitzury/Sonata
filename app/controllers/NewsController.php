<?php

class News {
    public function __construct()
    {
    }
    public function showById($params)
    {
        echo "This is showById ";
        print_r($params);
    }
    public function index()
    {
        echo "This is index";
    }
}

?>
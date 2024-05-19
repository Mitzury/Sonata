<?php

require_once 'BaseController.php';
class Main extends BaseController {
    public function index()
    {
        echo "This is index";
        require_once (template.'/404.tpl');
    }
}

?>
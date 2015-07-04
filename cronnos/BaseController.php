<?php
namespace cronnos\controllers;

use cronnos\printers\Printer;
use cronnos\helpers\Arr;

class BaseController
{
    public $defaultRoute;

    public function __construct($route = 'index')
    {
        $this->defaultRoute = $route;
        $route = Arr::get($_GET, 'rt', $this->defaultRoute);
        if (!function_exists($route)) {
            $p = new Printer;
            $p->view('errorPage/_404.php');
        } else {
            $this->init();
            $route();
        }
    }

    public function init()
    {}
}

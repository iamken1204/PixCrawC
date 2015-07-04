<?php
namespace cronnos\controllers;

use cronnos\printers\Printer;
use cronnos\helpers\Arr;

class BaseController
{
    public $defaultRoute;

    public $currentRoute;

    /**
     * DEFAULT function is 'index', you can specify another DEFAULT function
     * when newing a controller.
     * If you want to trigger other functions,
     * set the function name whithin $_GET['rt'].
     * @param string $route
     */
    public function __construct($route = 'index')
    {
        $this->defaultRoute = $route;
        $route = Arr::get($_GET, 'rt', $this->defaultRoute);
        $functions = get_class_methods($this);
        if (!in_array($route, $functions)) {
            $p = new Printer;
            $p->view('errorPage/_404.php');
        } else {
            $this->currentRoute = $route;
            $r = $this->currentRoute;
            call_user_func([$this, $r]);
            $this->init();
        }
    }

    public function init()
    {}
}

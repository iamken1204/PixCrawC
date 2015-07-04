<?php
namespace cronnos;

use cronnos\printers\Printer;

class BaseController
{
    public $defaultRoute;

    public function __construct($route = 'index')
    {
        $this->defaultRoute = $route;
        $route = Arr::get($_GET, 'rt', $this->defaultRoute);
        if (!function_exists($route)) {
            $p = new Printer;
            $p->view('errorPage/_404.php', [], false);
        }
        $this->init();
    }

    public function init()
    {}
}

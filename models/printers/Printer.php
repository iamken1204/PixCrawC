<?php
namespace models\printers;

use models\App;

class Printer
{
    public $assets_path;

    public $content;

    public function __construct()
    {
        $this->assets_path = App::$config['basePath'] . "/assets/";
    }

    /**
     * Render specific file (js or html)
     * Handle VIEW part of mvc
     * @param  string $fileName path and name of file which you want to render
     * @param  array  $params   variables will be used in rendered file
     */
    public function view($fileName = '', $params = [])
    {
        if (empty($fileName))
            return false;
        $fullPath = $this->assets_path . $fileName;
        if (file_exists($fullPath)) {
            $_SESSION['params'] = $params;
            $this->content = require($fullPath);
        } else
            return false;
    }
}

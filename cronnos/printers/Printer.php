<?php
namespace cronnos\printers;

use models\App;

class Printer
{
    public $view_path;

    public $content;

    public $default_layout;

    public $default_layout_path;

    public function __construct()
    {
        $this->view_path = App::$config['viewPath'];
        $this->default_layout = App::$config['defaultLayout'];
        $this->default_layout_path = App::$config['defaultLayoutPath'];
    }

    /**
     * Render specific file (js or html)
     * Handle VIEW part of mvc
     * User can choose not to use layout, set $layout to false,
     * then function withLayout() will not be triggered.
     * @param  string      $fileName path and name of file which you want to render
     * @param  array       $params   variables will be used in rendered file
     * @param  bool|string $layout   $layout has 3 conditions:
     *                               * true(bool) - will render default layout
     *                               * path(string) - will render specific layout
     *                               * false(bool) - will not render layout
     */
    public function view($fileName = '', $params = [], $layout = true)
    {
        if (empty($fileName))
            return false;
        $fullPath = $this->view_path . $fileName;
        if (file_exists($fullPath)) {
            $_SESSION['params'] = $params;
            if (!$layout) {
                $this->content = require($fullPath);
            } else {
                if (!is_string($layout))
                    $layout = $this->default_layout;
                $_SESSION['view_content'] = $fullPath;
                $this->withLayout($layout);
            }
        } else
            return false;
    }

    private function withLayout($layout)
    {
        $fullPath = $this->default_layout_path . $layout;
        if (!file_exists($fullPath))
            $fullPath = $this->default_layout_path . $this->default_layout;
        require($fullPath);
    }
}

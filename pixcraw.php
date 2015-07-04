<?php
include "autoload_app.php";

use cronnos\printers\Printer;
use models\PixCrawler\BloggerCrawler;
use models\PixCrawler\ArticleCrawler;
use cronnos\helpers\Arr;
use cronnos\helpers\ExceptionHandler;
use cronnos\helpers\VarDumper;
use cronnos\controllers\Controller;
use pixcraw;

class pixcraw extends Controller
{
    public function index()
    {
        $p = new Printer;
        $p->view('view_pixcraw.php');
    }

    public function getPixUrl($rank = 1, $target = 'blogger')
    {
        try {
            if (!is_numeric($rank))
                throw new \Exception("{Parameter must be a numeric!", 400);
            if ($target == 'blogger')
                $model = new BloggerCrawler;
            elseif ($target == 'article')
                $model = new ArticleCrawler;
            else
            $url = $model->getUrlByRank($rank);
            $res = [
                'code' => 200,
                'url' => $url
            ];
            return json_encode($res);
        } catch (\Exception $e) {
            $eh = new ExceptionHandler($e);
            return $eh::returnJson();
        }
    }
}
$p = new pixcraw('index');

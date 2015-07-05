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
            $data = $_POST;
            if (empty($data))
                throw new \Exception("Empty parameters!", 400);
            $rank = Arr::get($data, 'rank', false);
            $target = Arr::get($data, 'target', false);
            if (!is_numeric($rank))
                throw new \Exception("{Parameter must be a numeric!", 401);
            if ($target == 'blogger')
                $model = new BloggerCrawler;
            elseif ($target == 'article')
                $model = new ArticleCrawler;
            else
                throw new \Exception("Error Processing Target", 402);
            $result = $model->getUrlByRank($rank);
            if ($result['code'] != 200)
                throw new \Exception($result['message'], $result['code']);
            $res = [
                'code' => 200,
                'url' => $result,
                'domID' => 'rank-' . $rank
            ];
            echo json_encode($res);
        } catch (\Exception $e) {
            $eh = new ExceptionHandler($e);
            echo $eh::returnJson();
        }
    }
}
$p = new pixcraw('index');

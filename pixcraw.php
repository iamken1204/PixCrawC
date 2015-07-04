<?php
include "autoload_app.php";

// use models\PixCrawler\PixCraw;
use cronnos\printers\Printer;
use models\PixCrawler\BloggerCrawler;
use models\PixCrawler\ArticleCrawler;
use helpers\Arr;
use helpers\ExceptionHandler;

// $bc = new BloggerCrawler;
// var_dump($bc->getUrlByRank(1, 1));
// $ac = new ArticleCrawler;
// var_dump($ac->getUrlByRank(1));`
$route = Arr::get($_POST['data'], 'route', 'index');
if (function_exists($route)) {
    if ($route == 'getPixUrl') {
        $data = Arr::get($_POST, 'data', '');
        getPixUrl($data['rank'], $data['target']);
    } else {
        $route();
    }
} else {
    $res = [
        'code' => 404,
    ];
    return json_encode($res);
}

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
        if ($target == 'blogger') {
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

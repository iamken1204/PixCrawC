<?php
namespace models\PixCrawler;

use cronnos\helpers\ExceptionHandler as EH;
use cronnos\App;

class ArticleCrawler
{
    private static $baseUrl = 'https://www.pixnet.net/blog/articles/all/0/hot';

    private static $maxPage;

    private static $perPage = 10;

    public function __construct()
    {
        $basePath = App::$config['basePath'];
        include($basePath . '/cronnos/helpers/simple_html_dom.php');
    }

    public function getUrlByRank($rank = 0)
    {
        try {
            if (empty($rank))
                throw new \Exception("Parameter is empty!", 400);
            $page = floor($rank / self::$perPage) + 1;
            $url = self::$baseUrl . '/' . $page;
            $html = file_get_html($url);
            $content = $html->find('#content');
            if ($rank == 1) {
                $target = $content[0]->find('.featured');
            } else {
                $target = $content[0]->find(".rank-$rank");
                $target = $target[0]->find('h3');
            }
            $a = $target[0]->find('a');
            $result = '';
            foreach ($a as $r) {
                if (strpos($r, 'blog/post') !== false) {
                    $result = $r->href;
                    break;
                }
            }
            if (empty($result))
                $result = 'url:' . $rank . ' fetching error';
            $res = [
                'code' => 200,
                'url' => $result
            ];
            return $res;
        } catch (\Exception $e) {
            $eh = new EH($e);
            return $eh::returnArray();
        }
    }
}

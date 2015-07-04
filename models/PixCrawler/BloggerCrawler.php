<?php
namespace models\PixCrawler;

use cronnos\helpers\ExceptionHandler as EH;
use cronnos\App;

class BloggerCrawler
{
    private static $baseUrl = 'https://www.pixnet.net/blog/bloggers/group/';

    private static $maxPage = 7;

    private static $perPage = 15;

    public function __construct()
    {
        $basePath = App::$config['basePath'];
        include($basePath . '/helpers/simple_html_dom.php');
    }

    public function getUrlByRank($rank = 0, $category = 0)
    {
        try {
            if (empty($rank) || empty($category))
                throw new \Exception("Parameter is empty!", 400);
            $page = floor($rank / self::$perPage) + 1;
            $url = self::$baseUrl . $category . '/' . $page;
            $html = file_get_html($url);
            $content = $html->find('#content');
            if ($rank == 1) {
                $target = $content[0]->find('.top-blogger');
            } else {
                $target = $content[0]->find(".rank-$rank");
                $target = $target[0]->find('h3');
            }
            if (!empty($target)) {
                $a = $target[0]->find('.blog-title');
                $result = 'URL goto=' . $a[0]->href;
            } else {
                $result = '';
            }
            return $result;
        } catch (\Exception $e) {
            $eh = new EH($e);
            return $eh::returnJson();
        }
    }
}

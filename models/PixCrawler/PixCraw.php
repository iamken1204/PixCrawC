<?php
namespace models\PixCrawler;

class PixCraw
{
    /**
     * 熱門文章 前 100 名
     * @return [type] [description]
     */
    public function getTop100Article()
    {
        $baseUrl = 'https://www.pixnet.net/blog/articles/all/0/hot/';
        $urls = [];
        for ($i = 1; $i < 11; $i++) {
            $url = $baseUrl . $i;
            $html = file_get_html($url);
            $content = $html->find('#content');
            $levelStart = $i * 10 - 9;
            $levelEnd = $i * 10;
            for ($ii = $levelStart; $ii <= $levelEnd; $ii++) {
                if ($ii == 1) {
                    $target = $content[0]->find('.featured');
                } else {
                    $target = $content[0]->find(".rank-$ii");
                    $target = $target[0]->find('h3');
                }
                $a = $target[0]->find('a');
                $url = '';
                foreach ($a as $r) {
                    if (strpos($r, 'blog/post') !== false) {
                        $urls[$ii] = $r->href;
                        break;
                    }
                }
            }
        }
        return $this->render('view_top', [
            'title' => '熱門文章 前 100 名',
            'data' => $urls
        ]);
    }

    /**
     * 分類熱門部落客 前 100名
     * @return [type] [description]
     */
    public function getTop100Blogger()
    {
        $baseUrl = 'https://www.pixnet.net/blog/bloggers/group/';
        $urls = [];
        for ($category = 1; $category < 16; $category++) {
            for ($page = 1; $page < 8; $page++) {
                $url = $baseUrl . $category . '/' . $page;
                $html = file_get_html($url);
                $content = $html->find('#content');
                $levelStart = $page * 15 - 14;
                $levelEnd = $page * 15;
                for ($rank = $levelStart; $rank <= $levelEnd; $rank++) {
                    if ($rank > 100)
                        break;
                    if ($rank == 1) {
                        $target = $content[0]->find('.top-blogger');
                    } else {
                        $target = $content[0]->find(".rank-$rank");
                        $target = $target[0]->find('h3');
                    }
                    if (!empty($target)) {
                        $a = $target[0]->find('.blog-title');
                        $urls[$rank] = $a[0]->href;
                    } else {
                        $urls[$rank] = '';
                    }
                }
            }
        }
        return $this->render('view_top', [
            'title' => '分類熱門部落客 前 100名',
            'data' => $urls
        ]);
    }
}

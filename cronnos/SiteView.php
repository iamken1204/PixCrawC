<?php
namespace cronnos;

use cronnos\helpers\VarDumper;

/**
 * A class for processing site view's works
 * public methods:
 *     getViews()       get site views from database
 *     addViews()       add site views directly
 *     validateViews()  use in the condition of end-user's visiting,
 *                      add site views while user has no cookie of site views
 */
class SiteView
{
    /**
     * class medoo handling DB works
     * @var medoo
     * @see medoo.in
     */
    private static $db;

    private static $tableName = 'site';

    private static $views;

    private static $viewCookieName;

    private static $viewCookieValue;

    public function __construct()
    {
        self::init();
    }

    private static function init()
    {
        $config = App::$config;
        self::$db = App::$db;
        self::$viewCookieName = $config['viewCookieName'];
        self::$viewCookieValue = self::setViewCookieValue();
        self::$views = self::$db->select('site', 'views')[0];
    }

    /**
     * get site views
     * @return string self::$views
     */
    public static function getViews()
    {
        self::init();
        return self::$views;
    }

    /**
     * the cookie value will be encryped and changed every hour
     * @var string
     */
    private static function setViewCookieValue()
    {
        $cookie_value = md5('cronnosPHP' +
                            date("Y-m-d H:00:00", mktime(date('H')+1, date('i'), date('s'), date('m'), date('d'), date('Y'))));
        return $cookie_value;
    }

    /**
     * Judge whether the user has cookie and cookie's value was not overdue,
     * if not, add site views.
     * @return  bool
     */
    public function validateViews()
    {
        try {
            if (!$this->getViewsCookie()) {
                $remainTime = $this->getRemainTimeOfThisHour();
                setcookie(self::$viewCookieName,
                          self::$viewCookieValue,
                          time() + $remainTime);
                self::addViews();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Return false while the user has no view cookie or
     * the cookie value is overdue.
     * @return bool
     */
    private function getViewsCookie()
    {
        if (isset($_COOKIE[self::$viewCookieName]))
            if ($_COOKIE[self::$viewCookieName] == self::$viewCookieValue)
                return true;
        return false;
    }

    /**
     * In case of cookie's value has to be changed per hour,
     * return the remaining seconds of this hour to set cookie value.
     * @return  integer   remaining seconds of this hour
     */
    private function getRemainTimeOfThisHour()
    {
        $now = strtotime(date("Y-m-d H:i:s"));
        $nextHour = strtotime(date("Y-m-d H:00:00",
                              mktime(date('H')+1, date('i'), date('s'), date('m'), date('d'), date('Y'))));
        return $nextHour - $now;
    }

    /**
     * Update site views, default add mount is 1.
     * @param  string $addMounts
     * @return bool
     */
    public static function addViews($addMounts = '1')
    {
        try {
            self::init();
            $sv = self::$db->select(self::$tableName, [
                'views'
            ], [
                'id[=]' => '1'
            ]);
            if (empty($sv)) {
                self::$db->insert(self::$tableName, [
                    'views' => '0'
                ]);
            }
            self::$db->update(self::$tableName, [
                'views[+]' => $addMounts
            ],[
                'id[=]' => '1'
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

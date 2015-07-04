<?php
namespace cronnos\helpers;

use cronnos\helpers\Arr;

class IpProcessor
{
    /**
     * Fetch ip details
     * @return array $res [
     *                        'ip' => string,
     *                        'detail' => [
     *                            'HTTP_CLIENT_IP' => string,
     *                            'HTTP_X_FORWARDED_FOR' => string,
     *                            'REMOTE_ADDR' => string
     *                        ]
     *                    ]
     */
    public static function getIpDetail()
    {
        try {
            $detail = [
                'HTTP_CLIENT_IP' => Arr::get($_SERVER, 'HTTP_CLIENT_IP', ''),
                'HTTP_X_FORWARDED_FOR' => Arr::get($_SERVER, 'HTTP_X_FORWARDED_FOR', ''),
                'REMOTE_ADDR' => Arr::get($_SERVER, 'REMOTE_ADDR', '')
            ];
            if (!empty($detail['HTTP_CLIENT_IP']))
                $ip = $detail['HTTP_CLIENT_IP'];
            elseif (!empty($detail['HTTP_X_FORWARDED_FOR']))
                $ip = $detail['HTTP_X_FORWARDED_FOR'];
            else
                $ip = $detail['REMOTE_ADDR'];
            $res = [
                'ip' => $ip,
                'detail' => $detail
            ];
            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Judge whether the target ip is in varified ips or not.
     * @param  array  $varified_ips
     * @param  string $target_ip    default: current client ip
     * @return bool
     */
    public static function guard($varified_ips = [], $target_ip = '')
    {
        if (empty($target_ip)) {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))
                $target_ip = $_SERVER['HTTP_CLIENT_IP'];
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $target_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else
                $target_ip = $_SERVER['REMOTE_ADDR'];
        }

        return in_array($target_ip, $varified_ips);
    }
}

<?php
namespace helpers;

class ExceptionHandler
{
    private static $code;

    private static $message;

    private static $response;

    public function __construct(\Exception $e)
    {
        self::$code = $e->getCode();
        self::$message = $e->getMessage();
        self::$response = [
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ];
    }

    public static function returnJson()
    {
        return json_encode(self::$response);
    }

    public static function returnArray()
    {
        return self::$response;
    }
}

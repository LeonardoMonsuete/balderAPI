<?php

namespace Util;

class RotasUtil 
{

    /**
     * @return mixed
     */
    public static function getRoutes()
    {
        $url = self::getURLs();
        $request = [];

        $request['route'] = strtolower($url[0]);
        $request['resource'] = $url[1] ?? null;
        $request['id'] = $url[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];
        return $request;
    }

    /**
     * @return string
     */
    public static function getURLs()
    {
        $uri = $_SERVER['REQUEST_URI'];
        return explode('/', trim($uri, '/'));
    }
}
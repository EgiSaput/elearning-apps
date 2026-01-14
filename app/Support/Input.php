<?php

namespace App\Support;

class Input
{
    public static function all()
    {
        return request()->all();
    }

    public static function get($key = null, $default = null)
    {
        return request()->input($key, $default);
    }

    public static function hasFile($key)
    {
        return request()->hasFile($key);
    }

    public static function file($key = null)
    {
        return request()->file($key);
    }

    public static function __callStatic($name, $arguments)
    {
        $req = request();
        if (method_exists($req, $name)) {
            return call_user_func_array([$req, $name], $arguments);
        }
        return null;
    }
}

<?php



namespace App\Http;


class Session
{
    public static function start()
    {
        session_start();
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public static function remove($key){
        unset($_SESSION[$key]);
    }
}

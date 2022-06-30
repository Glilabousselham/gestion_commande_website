<?php

namespace App\Http;

use App\Models\Client;

class Auth
{
    
    public static function register($client)
    {
        $client = new Client($client);
        Session::set("client",serialize($client));
    }

    public static function logout()
    {
        Session::remove("client");
    }

    public static function client()
    {
        if (!Session::get("client")) {
            return false;
        }

        return unserialize(Session::get("client"));
    }
}

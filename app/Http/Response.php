<?php

namespace App\Http;


class Response
{
    public static function json($data, $success = true, $error = '', $redirect = false)
    {
        return json_encode([
            "data" => $data,
            "success" => $success,
            "error" => $error,
            "redirect" => $redirect
        ]);
    }
}

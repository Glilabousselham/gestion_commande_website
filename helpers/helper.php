<?php


function m_root_dir()
{
    return str_replace('\\', '/', dirname(__DIR__)) . '/';
}

function m_generate_token()
{
    return md5(uniqid(), false);
}

function view($view_name, $data = [])
{
    ob_start();

    extract($data);

    require  m_root_dir() . "/views/" . $view_name . ".view.php";

    return ob_get_clean();
}


function assets($asset)
{
    return dirname($_SERVER["PHP_SELF"]) . "/resources/assets/" . $asset;
}


function storage($imgpath)
{
    return dirname($_SERVER["PHP_SELF"]) . "/storage/" . $imgpath;
}

function route($route_name)
{
    $route_name = ltrim($route_name, '/');
    return dirname($_SERVER["PHP_SELF"]) . "/" . $route_name;;
}


function redirect($route, $data = [])
{

    $msg = '';

    if ($data) {
        foreach ($data as $key => $value) {
            $msg .= "$key=$value&";
        }

        $msg = "?" . trim($msg, "&");
    }

    header('Location: ' . route($route)  . $msg);
}

function back($data = [])
{

    $msg = '';

   if ($data) {
        # code...
        foreach ($data as $key => $value) {
            $msg .= "$key=$value&";
        }

        $msg =  "?" . trim($msg, "&");

   }


    header('Location: ' .  $_SERVER['HTTP_REFERER'] . $msg);
}

function print_array($array){
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
}
<?php



namespace App\Boot;

use App\Database\DB;
use App\Http\Request;
use App\Http\Route;
use App\Http\Session;

class Application
{

    public function run()
    {

        Session::start();

        $db = DB::init();

        if (!$db) die("no db connection");

        if (str_starts_with((new Request)->url(), "api")) require_once m_root_dir() . "/config/api.php";

        Route::resolve(new Request);
        
    }
}

<?php



namespace App\Controllers;

use App\Http\Request;
use App\Models\Article;

class IndexController
{
    public function index_view(Request $request)
    {
        if (isset($request->search)) {
            $lib = addslashes($request->search);
            $articles = Article::select("select * from article where lib_article like '%" . $lib . "%' and qte_stock_article not like 0");
        } else {
            $articles = Article::select("select * from article where qte_stock_article not like 0");
        }

        for ($i = 0; $i < count($articles); $i++) {
            if ($articles[$i]['qte_stock_article'] == 0) {
                unset($articles[$i]);
            }
        }

        shuffle($articles);

        return view("index", ['articles' => $articles]);
    }
}

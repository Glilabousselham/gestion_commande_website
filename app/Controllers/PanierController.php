<?php



namespace App\Controllers;

use App\Http\Request;
use App\Models\Article;

class PanierController
{
    public function panier_view(Request $request)
    {

        // en cour

        // get the articles selected and return the image of that article
        // and ratuen the view 
        // hhhh
        // hta lghada wkml asahbi malk mzayer

        if (!isset($request->articles)) {
            return view("panier");
        }
        
        $articles = explode(',',$request->articles);

        for ($i=0; $i < count($articles); $i++) { 
            if (!is_numeric($articles[$i])) {
                return back();
            }
        }

        $articles = Article::where_in("num_article", $articles);

        return view("panier",["articles"=>$articles]);
    }
}

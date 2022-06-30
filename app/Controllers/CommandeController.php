<?php



namespace App\Controllers;

use App\Http\Auth;
use App\Http\Request;
use App\Http\Response;
use App\Models\Article;
use App\Models\Commande;
use App\Models\Comporter;

class CommandeController
{
    public function confirmer(Request $request)
    {

        if (!Auth::client()) {
            return Response::json([], false, "connexion", route("seconnecter"));
        }



        $articles = [];


        foreach ($request as $id => $qte) {
            $article = [
                'id' => str_replace('id', '', $id),
                'qte' => $qte,
            ];

            array_push($articles, $article);
        }

        try {

            // create the command
            $cid = Auth::client()->num_client;
            $date = date("Y-m-d");
            Commande::create([
                'date_commande' => $date,
                'num_client' => $cid
            ]);


            $commande = new Commande(Commande::getLastRecord());


            // update articles


            $result = [];
            foreach ($articles as $article) {
                $qte = $article['qte'];
                $id = $article['id'];

                $article = Article::query("UPDATE article set qte_stock_article = qte_stock_article - $qte where num_article = $id and qte_stock_article >= $qte");

                // create the Comporter
                Comporter::create([
                    "num_commande" => $commande->num_commande,
                    "num_article" => $id,
                    "qte" => $qte,
                ]);
                $a = Article::find($id);
                if ($a) {
                    $result[] = [
                        "libelle" => $a['lib_article'],
                        "qte" => $qte,
                        "prix" => $a['prix_article'],
                    ];
                }
            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return Response::json([], false);
        }

        return Response::json($result, true, '', route('/'));
    }
}

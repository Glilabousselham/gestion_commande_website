<?php



namespace App\Controllers;

use App\Http\Auth;
use App\Http\Request;
use App\Models\Client;

class ConnexionController
{
    public function seconnecter_view()
    {
        if(Auth::client()){
            redirect("/");
        }
        return view("seconnecter");
    }
    public function inscription_view()
    {
        if(Auth::client()){
            redirect("/");
        }
        return view("inscription");
    }


    public function inscription(Request $request)
    {
        if (!isset($request->nom, $request->adresse, $request->pass)) {
            return back();
        }
        $nom = htmlspecialchars($request->nom);
        $ad = htmlspecialchars($request->adresse);
        $pass = htmlspecialchars($request->pass);

        if (strlen($nom) < 1 || strlen($ad) < 3 || strlen($pass) < 4) {
            return back();
        }

        $c = Client::create([
            "nom_client" => $nom,
            "adresse_client" => $ad,
            "pass_client" => $pass,
        ]);

        if (!$c) {
            return back();
        }

        Auth::register(Client::getLastRecord());

        return redirect("/");
    }

    public function seconnecter(Request $request)
    {
        if (!isset($request->nom,$request->pass)) {
            return back();
        }
        $nom = htmlspecialchars($request->nom);
        $pass = htmlspecialchars($request->pass);

        if (strlen($nom) < 1  || strlen($pass) < 4) {
            return back();
        }

        $client = Client::where([['nom_client',$nom]]);
        if (!$client) {
            return back();
        }

        if (!count($client)) {
            return back();
        }

        $client = $client[0];

        if ($client['pass_client'] != $pass) {
            return back();
        }


        Auth::register($client);

        return redirect("/");
    }

    public function deconnecter()
    {
        if (Auth::client()) {
            Auth::logout();
        }
        return back();
    }
}

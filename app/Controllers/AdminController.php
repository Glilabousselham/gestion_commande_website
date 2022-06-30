<?php



namespace App\Controllers;

use App\Database\DB;
use App\Http\Request;
use App\Http\Session;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Commande;

require m_root_dir() . "/config/admin.php";

class AdminController
{

    public function admin_login_view()
    {

        // var_dump($_SESSION);
        if (Session::get("admin")) {
            return redirect("admin_panel");
        }

        return view("admin_login");
    }

    public function admin_panel_view()
    {

        if (!Session::get("admin")) {
            return redirect('/admin_login');
        }

        return view("admin_panel");
    }

    public function ajouter_article_view()
    {
        if (!Session::get("admin")) {
            redirect("admin_login");
        }

        return view("ajouter_article");
    }

    public function gestion_article_view()
    {
        if (!Session::get("admin")) {
            redirect("admin_login");
        }

        $articles = Article::getAll();

        return view("gestion_articles", ["articles" => $articles]);
    }

    public function gestion_commandes_view()
    {
        if (!Session::get("admin")) {
            redirect("admin_login");
        }

        $query = "
            SELECT 
                co.num_commande as num_commande,
                co.date_commande as date_commande,
                cl.nom_client as nom_client
            FROM commande co
            INNER JOIN client cl
            using(num_client)
        ";


        $commandes = Commande::select($query);


        return view('gestion_commandes', ['commandes' => $commandes]);
    }

    public function admin_change_pass_view()
    {
        if (!Session::get("admin")) {
            redirect("admin_login");
        }
        return view("admin_change_pass");
    }

    public function admin_login(Request $request)
    {

        $username = addslashes($request->username);
        $password = $request->password;

        $admins = Admin::where([['username', $username]]);

        if (!$admins) {
            $error = "le nom de l'utilisatrue et le mote de pass sont invalid";
            $_SESSION['success'] = false;
            return redirect("admin_login");
        }

        if ($admins[0]['password'] !== $password) {
            $_SESSION['success'] = false;
            return redirect("admin_login");
        }

        Session::set("admin", true);
        return redirect("admin_panel");
    }

    public function admin_logout()
    {
        if (Session::get("admin")) {
            Session::remove('admin');
            return redirect("/");
        } else {
            return back();
        }
    }

    public function ajouter_article(Request $request)
    {

        if (!isset($request->libelle, $request->qte, $request->prix, $_FILES['img'])) {
            return back(['isset', "no info is set"]);
        }

        $accepts_types = ['webp', 'jpg', 'jpeg', 'png'];
        $errors = [];

        $libelle = addslashes(htmlspecialchars($request->libelle));
        if (is_numeric($libelle)) {
            $errors["libelle"] = "error";
        }


        $qte = addslashes(htmlspecialchars($request->qte));
        if (!is_numeric($qte) || $qte < 1) {
            $errors["qte"] = "error";
        }
        $prix = addslashes(htmlspecialchars($request->prix));
        if (!is_numeric($qte) || $qte < 1) {
            $errors["qte"] = "error";
        }
        $img = $_FILES['img'];
        $size = $img['size'];

        if ($size >  4 * 1024 * 1024) {
            $errors["size"] = "img size > 4 mb ";
        }

        $tmp_name = $img['tmp_name'];
        $name = $img['name'];
        $type = explode("/", $img['type']);

        $type = end($type);
        if (!in_array($type, $accepts_types)) {
            $errors['type'] = "le type de file n'esn pa supported";
        }

        if ($errors) {
            return back($errors);
        }

        // ajouter en image folder
        $name = explode('.', $name);
        $name = $name[0];

        $name = uniqid($name ?? "", true);

        $path_to_img = "images/" . $name . "." . $type;

        $uploaded = move_uploaded_file($tmp_name, m_root_dir() . "/storage/" . $path_to_img);

        if (!$uploaded) {
            return back(['error' => "something went wrong!"]);
        }


        // echo Article::getTable();
        $created = Article::create([
            "lib_article" => $libelle,
            "prix_article" => $prix,
            "qte_stock_article" => $qte,
            "img_article" => $path_to_img,
        ]);

        if (!$created) {
            unlink(m_root_dir() . "/storage/" . $path_to_img);
            $_SESSION['success'] = false;
            return back();
        }

        $_SESSION['success'] = true;
        return back();
    }

    public function supprimer_article(Request $request)
    {
        $id = addslashes($request->id);

        if (!is_numeric($id)) {
            return redirect("admin_panel");
        }

        if (!Session::get("admin")) {
            return redirect("/");
        }

        try {
            $deleted = Article::query("delete from article where num_article = " . $id);
        } catch (\Throwable $th) {
        }

        if (!$deleted) {
            $_SESSION['success'] = false;
            return redirect("gestion_articles");
        }
        $_SESSION['success'] = true;
        return redirect("gestion_articles");
    }

    public function admin_change_pass(Request $request)
    {

        if (!Session::get("admin")) {
            return redirect("/");
        }

        $old_pass = addslashes($request->old_pass);
        $new_pass = addslashes($request->pass);
        $confirm_pass = addslashes($request->confirmer_pass);

        $admin = Admin::where([['password', $old_pass]]);


        if (!$admin || count($admin) < 1) {

            return back(['error' => 'old password wrong']);
        }

        $admin = $admin[0];

        if ($new_pass !== $confirm_pass || strlen($new_pass) < 4) {
            # code...
            return back(['error' => 'new password and confirm is false ']);
        }

        $a = Admin::query("UPDATE ADMIN SET password = '" . $new_pass . "' WHERE id = " . $admin['id']);
        if (!$a) {
            return back(['error' => 'no update']);
        }

        return redirect('admin_panel');
    }

    public function supprimer_commande(Request $request)
    {

        if (!Session::get("admin")) {
            return redirect("/");
        }

        $id = addslashes($request->id);

        if (!is_numeric($id)) {
            // session message
            return back();
        }

        $deleted = Commande::delete($id);

        $_SESSION['success'] = true;
        if (!$deleted) {
            $_SESSION['success'] = false;
        }
        return back();
    }

    public function reset_db()
    {
        if (!Session::get("admin")) {
            $_SESSION['success'] = false;
            return redirect("/");
        }

        DB::drop();
        
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }


        return redirect('/');
    }
}

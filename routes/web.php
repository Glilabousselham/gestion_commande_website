<?php



// routes definition

use App\Controllers\AdminController;
use App\Controllers\CommandeController;
use App\Controllers\ConnexionController;
use App\Controllers\IndexController;
use App\Controllers\PanierController;
use App\Http\Route;



Route::get('/', [IndexController::class, 'index_view']);
Route::get('/index', [IndexController::class, 'index_view']);
Route::get('/panier', [PanierController::class, 'panier_view']);
Route::get('/seconnecter', [ConnexionController::class, 'seconnecter_view']);
Route::get('/inscription', [ConnexionController::class, 'inscription_view']);

Route::get("/admin_panel",[AdminController::class,"admin_panel_view"]);
Route::get("/admin_login",[AdminController::class,"admin_login_view"]);
Route::get("/ajouter_article",[AdminController::class,"ajouter_article_view"]);
Route::get("/gestion_articles", [AdminController:: class, "gestion_article_view"]);
Route::get("/gestion_commandes", [AdminController::class, "gestion_commandes_view"]);
Route::get( "/admin_change_pass", [AdminController::class, "admin_change_pass_view"]);



// post requests
Route::post('/inscription', [ConnexionController::class, 'inscription']);
Route::get('/deconnecter', [ ConnexionController::class, 'deconnecter']);
Route::post('/seconnecter', [ConnexionController::class, 'seconnecter']);


Route::post("/admin_login", [AdminController::class, "admin_login"]);
Route::get( "/admin_logout", [AdminController::class, "admin_logout"]);
Route::post("/ajouter_article", [AdminController::class, "ajouter_article"]);

// supprimer article 
Route::get( "/supprimer_article", [AdminController::class, "supprimer_article"]);
// supprimer commande 
Route::get("/supprimer_commande", [AdminController::class, "supprimer_commande"]);

// reset data base
Route::get("/reset_db", [AdminController::class, "reset_db"]);

// change the password of admin
Route::post("/admin_change_pass", [AdminController::class, "admin_change_pass"]);

// confirmation de commande
Route::post("confirmer_commande",[CommandeController::class,'confirmer']);
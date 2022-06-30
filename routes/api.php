<?php



// api routes

use App\Controllers\CommandeController;
use App\Http\Route;

Route::post("api/confirmer_commande", [CommandeController::class, 'confirmer']);
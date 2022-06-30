<?php


namespace App\Database;

use PDO;
use PDOException;

class DB
{

    private static string $DBNAME = '';
    private const USER = 'root';
    private const PASS = '';
    private const HOST = 'localhost';

    public static function connection()
    {
        $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::$DBNAME;

        try {
            $pdo = new PDO($dsn, self::USER, self::PASS);
            return $pdo;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function init()
    {
        //----------- la connection -----------


        $pdo = self::connection();

        if (!$pdo) return false;

        //------- creer la base de donne ------

        $query = "CREATE DATABASE IF NOT EXISTS glila_gestion_command character set UTF8 collate utf8_bin";

        $pdo->exec($query);

        self::$DBNAME = "glila_gestion_command";


        ///////////////////////////////////////        
        //---------- creer les table ----------
        ///////////////////////////////////////

        $queries = [];

        // client 
        $queries[] = "
            CREATE TABLE IF NOT EXISTS client (
                num_client INT PRIMARY KEY AUTO_INCREMENT,
                nom_client varchar(50) unique not null,
                adresse_client varchar(200) not null,
                pass_client varchar(200) not null
            )
        ";


        // command
        $queries[] = "
            CREATE TABLE IF NOT EXISTS commande (
                num_commande INT PRIMARY KEY AUTO_INCREMENT,
                date_commande DATE not null,
                num_client int not null,
                FOREIGN KEY (num_client) REFERENCES client(num_client) 
            )
        ";

        // article 
        $queries[] = "
            CREATE TABLE IF NOT EXISTS article (
                num_article INT PRIMARY KEY AUTO_INCREMENT,
                lib_article varchar(500) not null,
                prix_article float not null,
                img_article varchar(500) not null,
                qte_stock_article int not null
            )
        ";

        // comporter
        $queries[] = "
            CREATE TABLE IF NOT EXISTS comporter (
                num_commande INT ,
                num_article INT ,
                qte INT not null,
                FOREIGN KEY (num_commande) REFERENCES commande(num_commande) on Delete CASCADE on update cascade,
                FOREIGN KEY (num_article) REFERENCES article(num_article) on Delete set Null on update cascade
            )
        ";

        // admin
        $queries[] = "
            CREATE TABLE IF NOT EXISTS admin (
                id int primary key auto_increment,
                username varchar(20) not null,
                password varchar(20) not null
            )
        ";

        $pdo = self::connection();
        try {
            foreach ($queries as $query) {
                // echo $query . str_repeat("<br>",3);
                $pdo->exec($query);
            }

            // insert the admin

            $query = "SELECT * FROM admin ";

            $stmt = $pdo->prepare($query);

            $stmt->execute();

            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!count($admins)) {
                $query = "INSERT INTO admin(username ,password ) values ('admin','admin')";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            }
        } catch (\PDOException $th) {
            echo $th;
            return false;
        }






        return true;
    }

    public static function drop()
    {
        try {
            $pdo = self::connection();
            $query = "DROP DATABASE IF EXISTS " . self::$DBNAME;
            $pdo->exec($query);
            
        } catch (\PDOException $th) {
            echo $th;
            return false;
        }
        
    }
}

// /////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////////


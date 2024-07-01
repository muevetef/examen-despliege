<?php

namespace App\Controllers;

use Core\Authoritzatio;
use Core\Authorization;
use Core\Database;

class HomeController
{
    protected $db;

    function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    function index()
    {

        $trastos = $this->db->query('SELECT * FROM trastos ORDER BY created_at DESC LIMIT 3')->fetchall();
        //Pasarlos a la vista home y cargar la vista
        loadView('home', [
            'trastos' => $trastos
        ]);
    }
}

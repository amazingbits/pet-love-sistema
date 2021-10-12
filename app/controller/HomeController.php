<?php

namespace App\Controller;

use App\Core\DefaultController;

class HomeController extends DefaultController
{
    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }
        $this->render("home");
    }
}
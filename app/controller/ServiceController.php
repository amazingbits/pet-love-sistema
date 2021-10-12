<?php

namespace App\Controller;

use App\Core\DefaultController;

class ServiceController extends DefaultController
{
    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }
        $this->render("services/index");
    }
}
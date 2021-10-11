<?php

namespace App\Controller;

use App\Core\DefaultController;

class HomeController extends DefaultController
{
    public function index()
    {
        $this->render("home");
    }
}
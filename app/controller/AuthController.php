<?php

namespace App\Controller;

use App\Core\DefaultController;

class AuthController extends DefaultController
{
    public function login()
    {
        $this->render("login");
    }
}
<?php

namespace App\Controller;

use App\Core\DefaultController;

class AuthController extends DefaultController
{
    public function login()
    {
        if(isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH);
        }
        $this->render("login");
    }
}
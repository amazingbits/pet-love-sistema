<?php

namespace App\Controller;

use App\Core\DefaultController;

class ScheduleController extends DefaultController
{
    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }
        $this->render("schedule/index");
    }
}
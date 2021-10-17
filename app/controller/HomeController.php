<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\CurrentInformationHelper;

class HomeController extends DefaultController
{
    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }
        $currentInformationHelper = new CurrentInformationHelper();
        $data = [
            "now" => $currentInformationHelper->getCurrentDateInformation()
        ];

        $this->render("home", $data);
    }
}
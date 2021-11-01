<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\JWTHelper;

class ScheduleController extends DefaultController
{
    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }

        $jwtHelper = new JWTHelper();
        $userInfo = $jwtHelper->decryptJWT($_COOKIE["hash"]);
        $userId = (int)$userInfo->id;

        $ctx = stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => [
                    "Content-type: application/json\r\n"
                ],
                "ignore_errors" => true
            ]
        ]);

        $agendas = file_get_contents(API_URL . "/agenda/myappointments/" . $userId, null, $ctx);
        if(http_response_code() !== 200) {
            $agendas = [];
        } else {
            $agendas = json_decode($agendas);
        }

        $data = [
            "agendas" => $agendas
        ];

        $this->render("schedule/index", $data);
    }
}
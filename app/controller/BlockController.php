<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\JWTHelper;

class BlockController extends DefaultController
{
    private JWTHelper $jwtHelper;

    public function __construct()
    {
        $this->jwtHelper = new JWTHelper();
    }

    public function index()
    {
        if(!isset($_COOKIE["hash"])) {
            header("Location: " . BASE_PATH . "/auth");
        }

        $userInfo = $this->jwtHelper->decryptJWT($_COOKIE["hash"]);
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

        $response = file_get_contents(API_URL . "/bloqueio/myblocks/" . $userId, null, $ctx);
        if(http_response_code() !== 200) {
            $response = [];
        } else {
            $response = json_decode($response);
        }

        $agendas = file_get_contents(API_URL . "/agenda/myappointments/" . $userId, null, $ctx);
        if(http_response_code() !== 200) {
            $agendas = [];
        } else {
            $agendas = json_decode($agendas);
        }

        $data = [
            "bloqueios" => $response,
            "agendas" => $agendas,
            "userId" => $userId
        ];

        $this->render("blocks/index", $data);
    }
}
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

        $ctx = stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => [
                    "Content-type: application/json\r\n"
                ],
                "ignore_errors" => true
            ]
        ]);
        $response = file_get_contents(API_URL . "/agenda/id/desc/0/0/0", null, $ctx);
        if(http_response_code() !== 200) {
            $response = [];
        }
        $data = [
            "agendas" => $response
        ];

        $this->render("services/index", $data);
    }
}
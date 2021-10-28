<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\FileHelper;
use App\Helper\JWTHelper;

class UserController extends DefaultController
{
    public function new()
    {
        $this->render("user/new");
    }

    public function forgotPassword()
    {
        $this->render("user/forgotpassword");
    }

    public function changePassword($data)
    {
        $id = (int)$data["idUser"];
        $code = $data["code"];

        if(!isset($_COOKIE["forgotpassword"])) {
            header("Location: " . BASE_PATH . "/auth");
        }

        $data = [
            "idUser" => $id
        ];
        $this->render("user/changepassword", $data);
    }

    public function updateUserImg($data)
    {
        if(isset($_FILES)) {
            $fileHelper = new FileHelper();
            $fileHelper->createDirectory("user_img");

            $dir = __DIR__ . "/../../assets/media/user_img/";
            $size = 2000000;
            $imgTypes = ["jpg", "jpeg", "png", "gif"];
            $file = $_FILES["file"];
            $originalName = $dir . basename($file["name"]);
            $extension = mb_strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $name = trim($data["imgName"]);

            if($file["size"] > $size) {
                echo json_encode([
                    "message" => "A imagem deve ter no máximo 2mb",
                    "status" => 400
                ]);
                exit;
            }

            if(!in_array($extension, $imgTypes)) {
                echo json_encode([
                    "message" => "A extensão da imagem deve ser JPG, JPEG, PNG ou GIF",
                    "status" => 400
                ]);
                exit;
            }

            $fileHelper->deleteFile($name, "user_img");

            if(!@move_uploaded_file($file["tmp_name"], $dir . $name)) {
                echo json_encode([
                    "message" => "Houve um problema ao inserir a imagem!",
                    "status" => 400
                ]);
                exit;
            } else {

                echo json_encode([
                    "message" => "Imagem inserida com sucesso!",
                    "img_url" => $name,
                    "status" => 200
                ]);
                exit;
            }

        }
    }

    public function save()
    {
        $res = [];

        // tratando o arquivo de imagem
        if(isset($_FILES)) {
            $fileHelper = new FileHelper();
            $fileHelper->createDirectory("user_img");

            $dir = __DIR__ . "/../../assets/media/user_img/";
            $size = 2000000; // 2mb
            $imgTypes = ["jpg", "jpeg", "png", "gif"];
            $file = $_FILES["file"];
            $originalName = $dir . basename($file["name"]);
            $extension = mb_strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $newName = uniqid(md5(date("Y-m-d H:i:s"))) . "." . $extension;

            if($file["size"] > $size) {
                echo json_encode([
                    "message" => "A imagem deve ter no máximo 2mb",
                    "status" => 400
                ]);
                exit;
            }

            if(!in_array($extension, $imgTypes)) {
                echo json_encode([
                    "message" => "A extensão da imagem deve ser JPG, JPEG, PNG ou GIF",
                    "status" => 400
                ]);
                exit;
            }

            if(!@move_uploaded_file($file["tmp_name"], $dir . $newName)) {
                echo json_encode([
                    "message" => "Houve um problema ao inserir a imagem!",
                    "status" => 400
                ]);
                exit;
            } else {

                echo json_encode([
                    "message" => "Imagem inserida com sucesso!",
                    "img_url" => $newName,
                    "status" => 200
                ]);
                exit;
            }
        } else {
            echo json_encode([
                "message" => "Parâmetros insuficientes!"
            ]);
        }
    }

    public function myAccount()
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

        $endereco = file_get_contents(API_URL . "/endereco/" . $userId, null, $ctx);
        if(http_response_code() !== 200) {
            $endereco = [];
        } else {
            $endereco = json_decode($endereco);
        }

        $usuario = file_get_contents(API_URL . "/usuario/" . $userId, null, $ctx);
        if(http_response_code() !== 200) {
            $usuario = [];
        } else {
            $usuario = json_decode($usuario);
        }

        $data = [
            "usuario" => $usuario,
            "endereco" => $endereco
        ];

        $this->render("user/myaccount", $data);
    }
}
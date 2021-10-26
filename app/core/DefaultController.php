<?php

namespace App\Core;

use App\Helper\JWTHelper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DefaultController
{
    protected function render(string $view, array $params = []): void
    {
        $loader = new FilesystemLoader("app/view/");
        $twig = new Environment($loader);
        $twig->addGlobal("BASE_PATH", BASE_PATH);
        $twig->addGlobal("API_URL", API_URL);
        if(isset($_COOKIE["hash"])) {
            $jwtHelper = new JWTHelper();
            $userInfo = $jwtHelper->decryptJWT($_COOKIE["hash"]);
            $userId = (int)$userInfo->id;
            $twig->addGlobal("USER_ID", $userId);
        }
        try {
            echo $twig->render($view . ".twig.php", $params);
        } catch (\Exception $e) {
            die("Erro ao renderizar a página!");
        }
    }
}
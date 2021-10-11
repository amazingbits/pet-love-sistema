<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DefaultController
{
    protected function render(string $view, array $params = []): void
    {
        $loader = new FilesystemLoader("app/view/");
        $twig = new Environment($loader);
        $twig->addGlobal("BASE_PATH", BASE_PATH);
        try {
            echo $twig->render($view . ".twig.php", $params);
        } catch (\Exception $e) {
            die("Erro ao renderizar a página!");
        }
    }
}
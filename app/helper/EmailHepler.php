<?php

namespace App\Helper;

use App\Core\DefaultController;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailHepler
{
    private static string $user = "petlove@guiandrade.com.br";
    private static string $pass = "Senac3229*";
    private static int $port = 587;
    private static string $host = "mail.guiandrade.com.br";
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = self::$host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = self::$user;
        $this->mailer->Password = self::$pass;
        $this->mailer->Port = self::$port;

    }

    public function setFrom(string $fromEmail, string $fromName = "Pet Love"): void
    {
        try {
            $this->mailer->setFrom($fromEmail, $fromName);
        } catch (Exception $e) {
            echo json_encode([
                "message" => "Não foi possível configurar um e-mail de envio!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function addAddress(string $address): void
    {
        try {
            $this->mailer->addAddress($address);
        } catch (Exception $e) {
            echo json_encode([
                "message" => "Não foi possível adicionar o e-mail {$address} para envio na lista!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function send(string $body, string $subject = "E-mail de Pet Love"): void
    {
        $html = "<img src='https://guiandrade.com.br/uploads/emailheader.png' /><br><br>";
        $html .= $body;
        try {
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $html;
            $this->mailer->AltBody = strip_tags($body);
            $this->mailer->send();
        } catch (\Exception $e) {
            echo json_encode([
                "message" => "Não foi possível enviar o e-mail!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
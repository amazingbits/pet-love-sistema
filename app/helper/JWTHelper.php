<?php

namespace App\Helper;

use Firebase\JWT\JWT;

class JWTHelper
{
    private static string $key = "DA92EEE43F921EF601DA6B63C975A4FDD0259A8A407C8E0C29F17DB3812241C4";
    private array $payload;
    private static array $encryptType = ["HS256"];

    public function generateJWT(): string
    {
        return JWT::encode($this->payload, self::$key);
    }

    public function decryptJWT(string $jwt): object
    {
        return JWT::decode($jwt, self::$key, self::$encryptType);
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
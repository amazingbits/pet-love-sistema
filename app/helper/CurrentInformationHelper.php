<?php

namespace App\Helper;

class CurrentInformationHelper
{
    public function getCurrentDateInformation(): string
    {
        $meses = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        ];
        $diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];

        return date("d") . " de " . $meses[date("m")] . " de " . date("Y") . " - " . $diasSemana[date("w")];
    }
}
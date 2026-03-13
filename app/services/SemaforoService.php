<?php

declare(strict_types=1);

namespace App\Services;

class SemaforoService
{
    public static function calcular(string $fechaVencimiento, string $estatus): array
    {
        if ($estatus === 'CERRADO') {
            return ['semaforo' => 'GRIS', 'dias_restantes' => 0];
        }

        $hoy = new \DateTimeImmutable('today');
        $vencimiento = new \DateTimeImmutable($fechaVencimiento);
        $dias = (int)$hoy->diff($vencimiento)->format('%r%a');

        if ($dias > 10) {
            $color = 'VERDE';
        } elseif ($dias >= 1) {
            $color = 'AMARILLO';
        } else {
            $color = 'ROJO';
        }

        return ['semaforo' => $color, 'dias_restantes' => $dias];
    }
}

<?php

namespace App\Models;

use App\Interfaces\Reservable;

class DVD extends Material implements Reservable
{
    private int $duracio; // en minutos
    private ?string $usuariReserva = null;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $duracio
    ) {
        // TODO: parent::__construct(...) + setDuracio($duracio)
    }

    public function calcularMulta(int $diesRetard): float
    {
        // TODO: 1.00 € por día de retraso
    }

    public function getTipus(): string
    {
        // TODO: devuelve exactamente "DVD"
    }

    public function getDuracio(): int
    {
        return $this->duracio;
    }

    public function setDuracio(int $minuts): void
    {
        // TODO: validación > 0
    }

    public function getDuracioFormatada(): string
    {
        // TODO: 150 minutos -> "2h 30min" ; 45 minutos -> "0h 45min"
        // Pista: intdiv($this->duracio, 60) y $this->duracio % 60
    }

    // --- Reservable: misma lógica que en Llibre (puedes copiarla y adaptar) ---

    public function reservar(string $nomUsuari): bool
    {
        // TODO
    }

    public function cancelarReserva(): bool
    {
        // TODO
    }

    public function estaReservat(): bool
    {
        // TODO
    }

    public function getUsuariReserva(): ?string
    {
        return $this->usuariReserva;
    }
}

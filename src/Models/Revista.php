<?php

namespace App\Models;

// Ojo: Revista NO implementa Reservable (las revistas no se pueden reservar).
class Revista extends Material
{
    private int $numeroEdicio;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroEdicio
    ) {
        // TODO: llama a parent::__construct(...) con los 4 campos de Material
        // y asigna $numeroEdicio (usa el setter, igual que hace Llibre).
    }

    public function calcularMulta(int $diesRetard): float
    {
        // TODO: 0.25 € por día de retraso
    }

    public function getTipus(): string
    {
        // TODO: devuelve exactamente "Revista"
    }

    public function getNumeroEdicio(): int
    {
        return $this->numeroEdicio;
    }

    public function setNumeroEdicio(int $numero): void
    {
        // TODO: validación > 0, igual que en Llibre
    }
}

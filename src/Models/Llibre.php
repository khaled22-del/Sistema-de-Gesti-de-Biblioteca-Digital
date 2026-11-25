<?php

namespace App\Models;

use App\Interfaces\Reservable;

class Llibre extends Material implements Reservable
{
    private int $numeroPagines;
    private ?string $usuariReserva = null;

    // Constructor: tal cual lo da el enunciado (parent:: + setter con validación)
    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroPagines
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroPagines($numeroPagines); // el setter también valida
    }

    public function calcularMulta(int $diesRetard): float
    {
        // TODO: 0.50 € por día de retraso
    }

    public function getTipus(): string
    {
        // TODO: devuelve exactamente "Llibre"
    }

    public function getNumeroPagines(): int
    {
        return $this->numeroPagines;
    }

    public function setNumeroPagines(int $pagines): void
    {
        // TODO: si $pagines no es > 0, lanza \InvalidArgumentException
        // si es válido, asígnalo a $this->numeroPagines
    }

    // --- Reservable: implementa aquí los 4 métodos de la interfaz ---

    public function reservar(string $nomUsuari): bool
    {
        // TODO: si ya está reservado, devuelve false.
        // si no, guarda $nomUsuari en $usuariReserva, registra "reservat" y devuelve true.
    }

    public function cancelarReserva(): bool
    {
        // TODO: si no hay reserva, devuelve false.
        // si hay, ponla a null, registra "reserva_cancel·lada" y devuelve true.
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

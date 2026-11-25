<?php

namespace App\Models;

use App\Interfaces\Reservable;

// Llibre implementa Reservable: es pot reservar.
class Llibre extends Material implements Reservable
{
    private int $numeroPagines;
    private ?string $usuariReserva = null;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $numeroPagines
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroPagines($numeroPagines);
    }

    // Calcula la multa segons la tarifa de llibre: 0.50 per dia de retard.
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 0.50;
    }

    // Retorna el tipus exacte d'aquest material.
    public function getTipus(): string
    {
        return "Llibre";
    }

    public function getNumeroPagines(): int
    {
        return $this->numeroPagines;
    }

    // Assigna el numero de pagines validant que sigui mes gran que 0.
    public function setNumeroPagines(int $pagines): void
    {
        if ($pagines > 0) {
            $this->numeroPagines = $pagines;
        } else {
            throw new \InvalidArgumentException("El numero de pagines ha de ser mes gran que 0");
        }
    }

    // Reserva el material si no estava ja reservat per ningu.
    public function reservar(string $nomUsuari): bool
    {
        if ($this->usuariReserva !== null) {
            return false;
        }
        $this->usuariReserva = $nomUsuari;
        $this->registrarAccio("reservat");
        return true;
    }

    // Cancel·la la reserva actual, si n'hi ha alguna.
    public function cancelarReserva(): bool
    {
        if ($this->usuariReserva === null) {
            return false;
        }
        $this->usuariReserva = null;
        $this->registrarAccio("reserva_cancel·lada");
        return true;
    }

    // Comprova si el material te una reserva activa.
    public function estaReservat(): bool
    {
        return $this->usuariReserva !== null;
    }

    public function getUsuariReserva(): ?string
    {
        return $this->usuariReserva;
    }
}

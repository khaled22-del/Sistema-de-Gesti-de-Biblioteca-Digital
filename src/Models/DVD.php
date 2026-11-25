<?php

namespace App\Models;

use App\Interfaces\Reservable;

// DVD implementa Reservable: es pot reservar igual que Llibre.
class DVD extends Material implements Reservable
{
    private int $duracio; // en minuts
    private ?string $usuariReserva = null;

    public function __construct(
        int $id,
        string $titol,
        string $autor,
        int $anyPublicacio,
        int $duracio
    ) {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setDuracio($duracio);
    }

    // Calcula la multa segons la tarifa de DVD: 1.00 per dia de retard.
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 1.00;
    }

    // Retorna el tipus exacte d'aquest material.
    public function getTipus(): string
    {
        return "DVD";
    }

    public function getDuracio(): int
    {
        return $this->duracio;
    }

    // Assigna la durada validant que sigui mes gran que 0.
    public function setDuracio(int $minuts): void
    {
        if ($minuts > 0) {
            $this->duracio = $minuts;
        } else {
            throw new \InvalidArgumentException("La durada ha de ser mes gran que 0");
        }
    }

    // Formata la durada en hores i minuts, ex: 150 -> "2h 30min".
    public function getDuracioFormatada(): string
    {
        $hores = intdiv($this->duracio, 60);
        $minuts = $this->duracio % 60;
        return "{$hores}h {$minuts}min";
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

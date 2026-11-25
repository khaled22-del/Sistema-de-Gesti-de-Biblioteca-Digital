<?php

namespace App\Models;

// Revista no implementa Reservable: les revistes no es poden reservar.
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
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroEdicio($numeroEdicio);
    }

    // Calcula la multa segons la tarifa de revista: 0.25 per dia de retard.
    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 0.25;
    }

    // Retorna el tipus exacte d'aquest material.
    public function getTipus(): string
    {
        return "Revista";
    }

    public function getNumeroEdicio(): int
    {
        return $this->numeroEdicio;
    }

    // Assigna el numero d'edicio validant que sigui mes gran que 0.
    public function setNumeroEdicio(int $numero): void
    {
        if ($numero > 0) {
            $this->numeroEdicio = $numero;
        } else {
            throw new \InvalidArgumentException("El numero ha de ser mes gran que 0");
        }
    }
}

<?php

namespace App\Models;

class Prestec
{
    private \DateTime $dataPrestec;
    private ?\DateTime $dataRetorn = null;

    public function __construct(
        private Material $material,
        private Usuari $usuari,
        private int $diesLimitPrestec = 14,
        ?\DateTime $dataPrestec = null
    ) {
        $this->dataPrestec = $dataPrestec ?? new \DateTime();
    }

    public function retornar(): void
    {
        $this->dataRetorn = new \DateTime();
    }

    public function estaActiu(): bool
    {
        return $this->dataRetorn === null;
    }

    public function calcularDiesRetard(): int
    {
        // TODO: días que han pasado del límite (hasta el retorno, o hasta hoy si sigue activo).
        // 0 si no hay retraso. Pista: usa $this->dataPrestec->diff(...) y compara con diesLimitPrestec.
    }

    public function calcularMulta(): float
    {
        // TODO: usa calcularMulta() del material con los días de retraso de este préstamo
    }

    public function estaVencut(): bool
    {
        // TODO: true si se ha pasado el límite (y sigue activo)
    }

    public function getDiesPendents(): int
    {
        // TODO: días que quedan (negativo si está vencido)
    }

    // --- Getters ---
    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getUsuari(): Usuari
    {
        return $this->usuari;
    }

    public function getDataPrestec(): \DateTime
    {
        return $this->dataPrestec;
    }

    public function getDataRetorn(): ?\DateTime
    {
        return $this->dataRetorn;
    }

    public function getDiesLimitPrestec(): int
    {
        return $this->diesLimitPrestec;
    }
}

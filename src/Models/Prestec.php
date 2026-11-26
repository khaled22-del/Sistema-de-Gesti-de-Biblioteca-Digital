<?php

namespace App\Models;

// Representa el prestec d'un material a un usuari, amb control de dies i multa.
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

    // Tanca el prestec establint la data de retorn a ara mateix.
    public function retornar(): void
    {
        $this->dataRetorn = new \DateTime();
    }

    public function estaActiu(): bool
    {
        return $this->dataRetorn === null;
    }

    // Calcula els dies de retard (fins al retorn, o fins ara si segueix actiu).
    public function calcularDiesRetard(): int
    {
        $dataLimit = (clone $this->dataPrestec)->modify("+{$this->diesLimitPrestec} days");
        $dataFi = $this->dataRetorn ?? new \DateTime();

        if ($dataFi <= $dataLimit) {
            return 0;
        }

        return $dataLimit->diff($dataFi)->days;
    }

    // Delega el calcul de la multa al material, segons els seus dies de retard.
    public function calcularMulta(): float
    {
        return $this->material->calcularMulta($this->calcularDiesRetard());
    }

    // Esta vencut si encara es actiu i ja s'ha passat el dies de retard.
    public function estaVencut(): bool
    {
        return $this->estaActiu() && $this->calcularDiesRetard() > 0;
    }

    // Dies que queden fins al limit (negatiu si ja esta vencut).
    public function getDiesPendents(): int
    {
        $dataLimit = (clone $this->dataPrestec)->modify("+{$this->diesLimitPrestec} days");
        $dataFi = $this->dataRetorn ?? new \DateTime();

        $interval = $dataFi->diff($dataLimit);
        return $interval->invert ? -$interval->days : $interval->days;
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

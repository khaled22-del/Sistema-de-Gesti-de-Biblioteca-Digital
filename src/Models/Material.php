<?php

namespace App\Models;

use App\Traits\Auditoria;

/**
 * Representa qualsevol material de la biblioteca (Llibre, Revista, DVD).
 */
abstract class Material
{
    use Auditoria;

    protected bool $disponible = true;

    public function __construct(
        protected int $id,
        protected string $titol,
        protected string $autor,
        protected int $anyPublicacio
    ) {
    }

    // Cada subclasse calcula la seva propia tarifa de multa per dia de retard.
    abstract public function calcularMulta(int $diesRetard): float;

    // Cada subclasse retorna el seu propi nom exacte ("Llibre", "Revista", "DVD").
    abstract public function getTipus(): string;

    // Marca el material com a prestat si estava disponible; si no, retorna false.
    public function prestar(): bool
    {
        if ($this->disponible) {
            $this->disponible = false;
            $this->registrarAccio("prestat");
            return true;
        }
        return false;
    }

    // Marca el material com a disponible de nou i ho registra a l'historial.
    public function retornar(): void
    {
        $this->disponible = true;
        $this->registrarAccio("retornat");
    }

    // Retorna el material en el format de text exigit per l'enunciat.
    public function __toString(): string
    {
        $estat = $this->disponible ? "Disponible" : "No disponible";
        return "[{$this->getTipus()}] #{$this->id} - {$this->titol} ({$this->autor}, {$this->anyPublicacio}) - {$estat}";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitol(): string
    {
        return $this->titol;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getAnyPublicacio(): int
    {
        return $this->anyPublicacio;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }
}

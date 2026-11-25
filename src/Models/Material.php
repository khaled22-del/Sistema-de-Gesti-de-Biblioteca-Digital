<?php

namespace App\Models;

use App\Traits\Auditoria;

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

    // --- Métodos abstractos: cada subclase (Llibre/Revista/DVD) decide cómo ---
    abstract public function calcularMulta(int $diesRetard): float;

    abstract public function getTipus(): string;

    // --- Métodos concretos: AQUÍ VA TU LÓGICA ---

    public function prestar(): bool
    {
        // TODO:
        // - si $disponible es true: ponlo a false, registra la acción "prestat"
        //   (usa $this->registrarAccio(...) del trait Auditoria) y devuelve true.
        // - si ya no está disponible: devuelve false sin tocar nada.
    }

    public function retornar(): void
    {
        // TODO: marca el material como disponible otra vez
        // y registra la acción "retornat".
    }

    public function __toString(): string
    {
        // TODO: debe devolver EXACTAMENTE este formato (mira el enunciado):
        // [Llibre] #1 - El nom de la rosa (Umberto Eco, 1980) - Disponible
        // usa getTipus() para "Llibre"/"Revista"/"DVD", y "Disponible"/"No disponible"
        // según el valor de $disponible.
    }

    // --- Getters (triviales, ya los tienes) ---
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

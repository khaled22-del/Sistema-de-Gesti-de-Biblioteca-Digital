<?php

namespace App\Interfaces;

/**
 * Contrato para materiales que se pueden reservar (Llibre, DVD).
 * Una interfaz no tiene lógica, solo firmas: eso lo implementa cada clase.
 */
interface Reservable
{
    public function reservar(string $nomUsuari): bool;

    public function cancelarReserva(): bool;

    public function estaReservat(): bool;

    public function getUsuariReserva(): ?string;
}

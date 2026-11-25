<?php

namespace App\Traits;

/**
 * Trait reutilizable: lleva un historial de acciones ('prestat', 'retornat',
 * 'reservat', 'reserva_cancel·lada'). Lo usan todos los Material.
 */
trait Auditoria
{
    private array $historial = [];

    public function registrarAccio(string $accio, string $detalls = ''): void
    {
        // TODO: añade una entrada a $historial con el formato:
        // ['data' => 'Y-m-d H:i:s', 'accio' => ..., 'detalls' => ...]
        // Pista: date('Y-m-d H:i:s') te da la fecha/hora actual formateada.
    }

    public function obtenirHistorial(): array
    {
        return $this->historial;
    }

    public function obtenirUltimaAccio(): ?array
    {
        // TODO: devuelve la última entrada del historial, o null si está vacío.
        // Pista: end($this->historial) mueve el puntero al final y te devuelve ese elemento
        // (o false si el array está vacío).
    }

    public function netejarHistorial(): void
    {
        $this->historial = [];
    }
}

<?php

namespace App\Traits;

/**
 * Trait reutilitzable: porta un historial d'accions ('prestat', 'retornat',
 * 'reservat', 'reserva_cancel·lada'). L'utilitzen tots els Material.
 */
trait Auditoria
{
    private array $historial = [];

    // Afegeix una entrada nova a l'historial amb la data actual.
    public function registrarAccio(string $accio, string $detalls = ''): void
    {
        $this->historial[] = [
            'data' => date('Y-m-d H:i:s'),
            'accio' => $accio,
            'detalls' => $detalls,
        ];
    }

    public function obtenirHistorial(): array
    {
        return $this->historial;
    }

    // Retorna la darrera entrada de l'historial, o null si esta buit.
    public function obtenirUltimaAccio(): ?array
    {
        if (empty($this->historial)) {
            return null;
        }
        return end($this->historial);
    }

    public function netejarHistorial(): void
    {
        $this->historial = [];
    }
}

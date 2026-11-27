<?php

namespace App\Models;

use App\Interfaces\Reservable;
use App\Exceptions\MaterialNoTrobatException;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoPrestatException;
use App\Exceptions\UsuariNoTrobatException;

// Classe central: gestiona materials, usuaris, prestecs i reserves.
class Biblioteca
{
    private array $materials = [];
    private array $usuaris = [];
    private array $prestecs = [];

    public function __construct(private string $nom)
    {
    }

    public function afegirMaterial(Material $material): void
    {
        $this->materials[$material->getId()] = $material;
    }

    // Elimina el material amb aquest id; retorna false si no existia.
    public function eliminarMaterial(int $id): bool
    {
        if (!isset($this->materials[$id])) {
            return false;
        }
        unset($this->materials[$id]);
        return true;
    }

    public function cercarPerId(int $id): ?Material
    {
        return $this->materials[$id] ?? null;
    }

    public function cercarPerTitol(string $titol): array
    {
        return array_filter($this->materials, fn($m) => stripos($m->getTitol(), $titol) !== false);
    }

    public function cercarPerAutor(string $autor): array
    {
        return array_filter($this->materials, fn($m) => stripos($m->getAutor(), $autor) !== false);
    }

    public function llistarDisponibles(): array
    {
        return array_filter($this->materials, fn($m) => $m->isDisponible());
    }

    public function llistarPrestats(): array
    {
        return array_filter($this->materials, fn($m) => !$m->isDisponible());
    }

    public function llistarPerTipus(string $tipus): array
    {
        return array_filter($this->materials, fn($m) => $m->getTipus() === $tipus);
    }

    // Prestecs sense data de retorn (encara en curs).
    public function llistarPrestecsActius(): array
    {
        return array_filter($this->prestecs, fn($p) => $p->estaActiu());
    }

    // Materials reservats: nomes els que implementen Reservable i tenen reserva activa.
    public function llistarReserves(): array
    {
        return array_filter(
            $this->materials,
            fn($m) => $m instanceof Reservable && $m->estaReservat()
        );
    }

    // Tots els prestecs (actius i retornats) d'un usuari concret.
    public function llistarPrestecsUsuari(int $usuariId): array
    {
        return array_filter(
            $this->prestecs,
            fn($p) => $p->getUsuari()->id === $usuariId
        );
    }

    public function afegirUsuari(Usuari $usuari): void
    {
        $this->usuaris[$usuari->id] = $usuari;
    }

    // Union type: si l'identificador es un int, cerca per id; si es un string, per nom.
    public function cercarUsuari(int|string $identificador): ?Usuari
    {
        if (is_int($identificador)) {
            return $this->usuaris[$identificador] ?? null;
        }
        foreach ($this->usuaris as $usuari) {
            if ($usuari->nom === $identificador) {
                return $usuari;
            }
        }
        return null;
    }

    // Crea un prestec, comprovant material i usuari, i que estigui disponible.
    public function prestarMaterial(int $materialId, int $usuariId, ?\DateTime $dataPrestec = null): Prestec
    {
        $material = $this->cercarPerId($materialId);
        if ($material === null) {
            throw new MaterialNoTrobatException("No existeix cap material amb ID {$materialId}");
        }

        $usuari = $this->cercarUsuari($usuariId);
        if ($usuari === null) {
            throw new UsuariNoTrobatException("No existeix cap usuari amb ID {$usuariId}");
        }

        if ($material instanceof Reservable && $material->estaReservat()) {
            if ($material->getUsuariReserva() !== $usuari->nom) {
                throw new MaterialNoDisponibleException($materialId, "Material reservat per un altre usuari");
            }
            $material->cancelarReserva();
        } elseif (!$material->isDisponible()) {
            throw new MaterialNoDisponibleException($materialId, "Material ja prestat");
        }

        $material->prestar();
        $prestec = new Prestec($material, $usuari, 14, $dataPrestec);
        $this->prestecs[] = $prestec;
        $usuari->afegirPrestec($material);

        return $prestec;
    }

    // Tanca el prestec actiu d'aquest material i retorna l'import de la multa.
    public function retornarMaterial(int $materialId): float
    {
        foreach ($this->prestecs as $prestec) {
            if ($prestec->getMaterial()->getId() === $materialId && $prestec->estaActiu()) {
                $multa = $prestec->calcularMulta();
                $prestec->retornar();
                $prestec->getMaterial()->retornar();
                return $multa;
            }
        }
        throw new MaterialNoPrestatException("El material amb ID {$materialId} no estava prestat");
    }

    public function reservarMaterial(int $materialId, int $usuariId): bool
    {
        $material = $this->cercarPerId($materialId);
        if ($material === null) {
            throw new MaterialNoTrobatException("No existeix cap material amb ID {$materialId}");
        }
        if (!($material instanceof Reservable)) {
            throw new MaterialNoDisponibleException($materialId, "Les revistes no es poden reservar");
        }

        $usuari = $this->cercarUsuari($usuariId);
        if ($usuari === null) {
            throw new UsuariNoTrobatException("No existeix cap usuari amb ID {$usuariId}");
        }

        return $material->reservar($usuari->nom);
    }

    // Permet getLlibres/getRevistes/getDVDs/getMaterials/getUsuaris/getNom
    // sense tenir-los definits com a metodes reals; la resta, excepcio.
    public function __call(string $name, array $arguments): mixed
    {
        return match ($name) {
            'getLlibres' => $this->llistarPerTipus('Llibre'),
            'getRevistes' => $this->llistarPerTipus('Revista'),
            'getDVDs' => $this->llistarPerTipus('DVD'),
            'getMaterials' => $this->materials,
            'getUsuaris' => $this->usuaris,
            'getNom' => $this->nom,
            default => throw new \BadMethodCallException("Metode {$name} no existeix a Biblioteca"),
        };
    }

    public function obtenirEstadistiques(): array
    {
        $multesPendents = 0.0;
        foreach ($this->llistarPrestecsActius() as $prestec) {
            if ($prestec->estaVencut()) {
                $multesPendents += $prestec->calcularMulta();
            }
        }

        return [
            'total' => count($this->materials),
            'disponibles' => count($this->llistarDisponibles()),
            'prestats' => count($this->llistarPrestats()),
            'reservats' => count($this->llistarReserves()),
            'perTipus' => [
                'Llibre' => count($this->llistarPerTipus('Llibre')),
                'Revista' => count($this->llistarPerTipus('Revista')),
                'DVD' => count($this->llistarPerTipus('DVD')),
            ],
            'multesPendents' => $multesPendents,
        ];
    }
}

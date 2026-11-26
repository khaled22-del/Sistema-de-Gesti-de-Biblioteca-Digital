<?php

namespace App\Models;

use App\Exceptions\EmailInvalidException;

// Representa un usuari de la biblioteca, amb els seus prestecs i notificacions.
class Usuari
{
    private int $id;
    private string $nom;
    private string $email;
    private array $materialsPrestats = [];
    private \DateTime $dataRegistre;
    private array $notificacions = [];

    public function __construct(int $id, string $nom, string $email)
    {
        if (!$this->validarEmail($email)) {
            throw new EmailInvalidException("Email no valid");
        }
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->dataRegistre = new \DateTime();
    }

    // Permet llegir id, nom, email i dataRegistre des de fora; la resta, null.
    public function __get(string $propietat): mixed
    {
        return match ($propietat) {
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email,
            'dataRegistre' => $this->dataRegistre,
            default => null,
        };
    }

    // Nomes permet modificar l'email, validant-lo abans d'assignar-lo.
    public function __set(string $propietat, mixed $valor): void
    {
        if ($propietat === 'email') {
            if (!$this->validarEmail($valor)) {
                throw new EmailInvalidException("Email no valid");
            }
            $this->email = $valor;
        } else {
            throw new \LogicException("No es pot modificar la propietat {$propietat}");
        }
    }

    // Indica quines propietats es serialitzen (totes menys notificacions).
    public function __sleep(): array
    {
        return ['id', 'nom', 'email', 'dataRegistre', 'materialsPrestats'];
    }

    // Reinicialitza les notificacions en deserialitzar l'objecte.
    public function __wakeup(): void
    {
        $this->notificacions = [];
    }

    // Retorna el format de text exigit per l'enunciat.
    public function __toString(): string
    {
        return "{$this->nom} <{$this->email}> - {$this->getNumeroMaterialsPrestats()} prestecs";
    }

    // Afegeix un material a la llista de prestecs d'aquest usuari.
    public function afegirPrestec(Material $material): void
    {
        $this->materialsPrestats[] = $material;
    }

    // Treu de la llista el material que tingui aquest id.
    public function eliminarPrestec(int $materialId): void
    {
        $this->materialsPrestats = array_filter(
            $this->materialsPrestats,
            fn($m) => $m->getId() !== $materialId
        );
    }

    public function getMaterialsPrestats(): array
    {
        return $this->materialsPrestats;
    }

    public function getNumeroMaterialsPrestats(): int
    {
        return count($this->materialsPrestats);
    }

    public function afegirNotificacio(string $missatge): void
    {
        $this->notificacions[] = $missatge;
    }

    // Retorna les notificacions pendents i les buida despres.
    public function obtenirNotificacions(): array
    {
        $obtenir = $this->notificacions;
        $this->notificacions = [];
        return $obtenir;
    }

    // Comprova que l'email tingui un format valid.
    private function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

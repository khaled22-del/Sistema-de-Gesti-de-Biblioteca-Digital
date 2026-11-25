<?php

namespace App\Models;

class Usuari
{
    private int $id;
    private string $nom;
    private string $email;
    private array $materialsPrestats = []; // objetos Material
    private \DateTime $dataRegistre;
    private array $notificacions = [];

    public function __construct(int $id, string $nom, string $email)
    {
        // TODO:
        // - valida el email con validarEmail(); si no es válido, lanza
        //   \App\Exceptions\EmailInvalidException (recuerda importarla con use)
        // - asigna $id, $nom, $email
        // - inicializa $dataRegistre con la fecha actual (new \DateTime())
    }

    // --- Métodos mágicos obligatorios ---

    public function __get(string $propietat): mixed
    {
        // TODO: permite leer id, nom, email, dataRegistre. Para cualquier otra, devuelve null.
        // Pista: un match o un switch sobre $propietat.
    }

    public function __set(string $propietat, mixed $valor): void
    {
        // TODO: solo permite modificar 'email' (con validación).
        // Para cualquier otra propiedad, lanza \LogicException.
    }

    public function __sleep(): array
    {
        // TODO: devuelve el array de nombres de propiedades a serializar,
        // EXCEPTO 'notificacions'. Ej: ['id', 'nom', 'email', ...]
    }

    public function __wakeup(): void
    {
        // TODO: reinicializa $notificacions como array vacío
    }

    public function __toString(): string
    {
        // TODO: formato exacto -> Anna Puig <anna@mail.com> - 2 préstecs
    }

    // --- Gestión de préstamos y notificaciones ---

    public function afegirPrestec(Material $material): void
    {
        // TODO: añade $material a $materialsPrestats
    }

    public function eliminarPrestec(int $materialId): void
    {
        // TODO: quita de $materialsPrestats el material cuyo getId() == $materialId
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

    public function obtenirNotificacions(): array
    {
        // TODO: devuelve $notificacions Y LAS VACÍA después (dos pasos)
    }

    private function validarEmail(string $email): bool
    {
        // TODO: usa filter_var($email, FILTER_VALIDATE_EMAIL) !== false
    }
}

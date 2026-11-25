<?php

namespace App\Models;

use App\Interfaces\Reservable;
use App\Exceptions\MaterialNoTrobatException;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoPrestatException;
use App\Exceptions\UsuariNoTrobatException;

class Biblioteca
{
    private array $materials = []; // indexado por id del material
    private array $usuaris = [];   // indexado por id del usuario
    private array $prestecs = [];  // todos los Prestec (activos y retornados)

    public function __construct(private string $nom)
    {
    }

    // --- Gestión de materiales ---

    public function afegirMaterial(Material $material): void
    {
        // TODO: guárdalo en $materials indexado por su id
    }

    public function eliminarMaterial(int $id): bool
    {
        // TODO: devuelve false si no existe
    }

    public function cercarPerId(int $id): ?Material
    {
        // TODO
    }

    public function cercarPerTitol(string $titol): array
    {
        // TODO: materiales cuyo título contiene el texto (sin distinguir mayúsculas)
        // Pista: stripos() o mb_stripos()
    }

    public function cercarPerAutor(string $autor): array
    {
        // TODO: igual que cercarPerTitol pero por autor
    }

    // --- Listados ---

    public function llistarDisponibles(): array
    {
        // TODO: array_filter sobre $materials por isDisponible()
    }

    public function llistarPrestats(): array
    {
        // TODO
    }

    public function llistarPerTipus(string $tipus): array
    {
        // TODO: "Llibre", "Revista" o "DVD" -- filtra por getTipus()
    }

    public function llistarPrestecsActius(): array
    {
        // TODO: préstamos sin fecha de retorno (estaActiu())
    }

    public function llistarReserves(): array
    {
        // TODO: materiales reservados -- usa instanceof Reservable y estaReservat()
    }

    public function llistarPrestecsUsuari(int $usuariId): array
    {
        // TODO: todos los Prestec de ese usuario (activos y retornados)
    }

    // --- Gestión de usuarios ---

    public function afegirUsuari(Usuari $usuari): void
    {
        // TODO
    }

    public function cercarUsuari(int|string $identificador): ?Usuari
    {
        // TODO: si es int, busca por id. Si es string, busca por nombre.
        // Pista: is_int($identificador) para distinguir
    }

    // --- Gestión de préstamos y reservas ---

    public function prestarMaterial(int $materialId, int $usuariId, ?\DateTime $dataPrestec = null): Prestec
    {
        // TODO:
        // 1. busca el material; si no existe -> throw MaterialNoTrobatException
        // 2. busca el usuario; si no existe -> throw UsuariNoTrobatException
        // 3. si el material ya está prestado, o reservado por OTRO usuario -> throw MaterialNoDisponibleException
        //    (si está reservado por el MISMO usuario: se presta y se cancela la reserva)
        // 4. crea el Prestec, guárdalo en $prestecs, añádelo al usuario (afegirPrestec)
        //    y marca el material como prestado (prestar())
        // 5. devuelve el Prestec creado
    }

    public function retornarMaterial(int $materialId): float
    {
        // TODO:
        // - busca el préstamo activo de ese material; si no estaba prestado -> throw MaterialNoPrestatException
        // - ciérralo (retornar() del Prestec), calcula la multa, marca el material disponible (retornar())
        // - devuelve el importe de la multa (0 si no hay)
    }

    public function reservarMaterial(int $materialId, int $usuariId): bool
    {
        // TODO:
        // - busca el material; si no implementa Reservable -> throw MaterialNoDisponibleException
        //   con el mensaje "Les revistes no es poden reservar"
        // - si lo implementa, llama a su reservar($nomUsuari) y devuelve el resultado
    }

    // --- Método mágico __call ---

    public function __call(string $name, array $arguments): mixed
    {
        // TODO: debe permitir estas llamadas sin tener los métodos definidos:
        // - getLlibres() / getRevistes() / getDVDs()  -> filtran $materials por tipo
        // - getMaterials() / getUsuaris() / getNom()  -> devuelven las propiedades directamente
        // - cualquier otro método inexistente -> throw \BadMethodCallException
        // Pista: un match($name) { 'getLlibres' => ..., 'getRevistes' => ..., default => ... }
    }

    // --- Estadísticas ---

    public function obtenirEstadistiques(): array
    {
        // TODO: devuelve un array con esta estructura (mira el enunciado para el ejemplo):
        // [
        //   'total' => ..., 'disponibles' => ..., 'prestats' => ..., 'reservats' => ...,
        //   'perTipus' => ['Llibre' => N, 'Revista' => N, 'DVD' => N],
        //   'multesPendents' => ...   (suma de multas de préstamos vencidos activos)
        // ]
    }
}

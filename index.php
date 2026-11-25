<?php

// Único punto de entrada. El autoloader SIEMPRE antes de session_start().
require_once __DIR__ . '/vendor/autoload.php';

use App\Data\DataGenerator;
use App\Exceptions\MaterialNoDisponibleException;

session_start();

if (!isset($_SESSION['biblioteca'])) {
    $_SESSION['biblioteca'] = DataGenerator::crear();
}

$biblioteca = $_SESSION['biblioteca'];

if (($_GET['page'] ?? '') === 'reset') {
    session_destroy();
    header('Location: index.php');
    exit;
}

$page = $_GET['page'] ?? 'inici';

try {
    $vista = match ($page) {
        'inici'          => 'views/inici.php',
        'materials'      => 'views/materials.php',
        'material'       => 'views/material.php',
        'usuaris'        => 'views/usuaris.php',
        'usuari'         => 'views/usuari.php',
        'prestec'        => 'views/prestec.php',
        'retorn'         => 'views/retorn.php',
        'prestecs'       => 'views/prestecs.php',
        'reserva'        => 'views/reserva.php',
        'reserves'       => 'views/reserves.php',
        'estadistiques'  => 'views/estadistiques.php',
        'auditoria'      => 'views/auditoria.php',
        'demo_magic'         => 'views/demo_magic.php',
        'demo_serialization' => 'views/demo_serialization.php',
        'demo_exceptions'    => 'views/demo_exceptions.php',
        'demo_autoload'      => 'views/demo_autoload.php',
        default          => 'views/404.php',
    };
    require $vista;
} catch (MaterialNoDisponibleException $e) {
    $error = (string) $e; // usa el __toString() personalizado
    require 'views/error.php';
} catch (\Exception $e) {
    $error = $e->getMessage();
    require 'views/error.php';
}

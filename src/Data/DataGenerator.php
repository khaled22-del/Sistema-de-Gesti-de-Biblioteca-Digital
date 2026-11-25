<?php

namespace App\Data;

use App\Models\Biblioteca;
use App\Models\Llibre;
use App\Models\Revista;
use App\Models\DVD;
use App\Models\Usuari;

class DataGenerator
{
    public static function crear(): Biblioteca
    {
        // TODO: crea una Biblioteca y rellénala con, como mínimo:
        // - 4 llibres, 3 revistes, 3 DVDs (con datos reales, no "Llibre 1")
        // - 4 usuaris
        // - 2 préstamos activos (prestarMaterial), UNO de ellos VENCIDO
        //   (pista: pasa un $dataPrestec antiguo, ej. new \DateTime('-30 days'))
        // - 1 reserva (reservarMaterial)
        // y devuelve esa Biblioteca ya cargada.
    }
}

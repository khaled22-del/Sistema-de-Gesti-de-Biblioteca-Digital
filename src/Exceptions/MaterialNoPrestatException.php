<?php

namespace App\Exceptions;

use Exception;

// Se lanza cuando se quiere retornar un material que no estaba prestado.
class MaterialNoPrestatException extends Exception
{
}

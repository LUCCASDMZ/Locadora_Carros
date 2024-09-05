<?php

namespace App\Repositories;

use App\Models\Modelo;

class ModeloRepository
{
    protected $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    public function getAll($atributosMarcas = null, $filtro = null, $atributos = null)
    {
        $query = $this->modelo->with('marca');

        if ($atributosMarcas) {
            $query->with('marca:id,' . $atributosMarcas);
        }

        if ($filtro) {
            $filtros = explode(';', $filtro);
            foreach ($filtros as $condicao) {
                list($campo, $operador, $valor) = explode(':', $condicao);
                $query->where($campo, $operador, $valor);
            }
        }

        if ($atributos) {
            $query->selectRaw($atributos);
        }

        return $query->get();
    }
}

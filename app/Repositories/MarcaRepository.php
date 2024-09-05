<?php

namespace App\Repositories;

use App\Models\Marca;

class MarcaRepository
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function getAll($atributosModelos = null, $filtro = null, $atributos = null)
    {
        $query = $this->marca->with('modelos');

        if ($atributosModelos) {
            $query->with('modelos:id,' . $atributosModelos);
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
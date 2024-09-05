<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class MarcaRepository {

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

    }
    public function selectAtributosRegistroRelacioandos($atributos) {
        $this->model = $this->model->with($atributos);
    }

    public function filtro($filtros)
    {
        
    }
}

?>

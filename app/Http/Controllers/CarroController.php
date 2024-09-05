<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    protected $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }

    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')) {
            $atributos_modelo = 'modelo:id,'.$request->atributos_modelo;
            $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $carroRepository->selectAtributos($request->atributos);
        }

        return response()->json($carroRepository->getResultado(), 200);
    }



    public function store(StoreCarroRequest $request)
    {
        $carro = $this->carro->create($request->validated());

        return response()->json([
            'msg'=> 'O carro foi registrado com sucesso',
            'carro' => $carro
        ], 202);
    }


    public function show($id)
    {
        $carro = $this->carro->find($id);

        if(!$carro) {
            return response()->json([
            'eror'=> 'O carro não existe',
            ], 404);
        }

        return response()->json(['carro' =>$carro], 202);
    }


    public function update(UpdateCarroRequest $request, $id)
    {
        $carro = $this->carro->find($id);

        if(!$carro) {
            return response()->json([
            'eror'=> 'O carro não existe',
            ], 404);
        }

        $carro->update($request->validated());

        return response()->json([
            'msg' => 'Carro atualizado com sucesso',
            $carro
            ], 202);
    }

    public function destroy($id)
    {
        $carro = $this->carro->find($id);

        $carro->delete();

        return response()->json(['msg'=> 'Carro excluido com sucesso'], 202);
    }
}

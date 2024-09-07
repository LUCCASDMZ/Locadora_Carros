<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    protected $locacao;
    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }

    public function index(Request $request)
    {

        $locacaoRepository = new LocacaoRepository($this->locacao);

        if($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }

        return response()->json($locacaoRepository->getResultado(), 200);
    }


    public function store(StoreLocacaoRequest $request)
    {
        $locacao = $this->locacao->create($request->validated());

        return response()->json([
            'msg'=> 'Locação criada com sucesso',
            $locacao
        ], 202);
    }


    public function show($id)
    {
        $locacao = $this->locacao->find($id);

        if(!$locacao){
            return response()->json([
                'error' => 'Locação nao encontrada'
            ], 404);
        }

        return response()->json($locacao);
    }


    public function update(UpdateLocacaoRequest $request, $id)
    {
        $locacao = $this->locacao->find($id);
        $dadosValidados = $request->validated();

        $locacao->update($dadosValidados);

        return response()->json([
            'msg' => 'Locação atualizada com sucesso',
            $locacao
        ], 202);
    }


    public function destroy($id)
    {
        $locacao = $this->locacao->find($id);


        if(!$locacao){
            return response()->json([
                'error' => 'Locação nao encontrada'
            ], 404);
        }

        $locacao->delete();

        return response()->json([
            'msg' => 'Locação deletada com sucesso',
            $locacao
        ], 202);
    }
}

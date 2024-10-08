<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultadoPaginado(3), 200);
    }


    public function store(StoreMarcaRequest $request)
    {
        $marca = $this->marca->create($request->validated());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/marcas','public');
        $marca->imagem = $imagem_urn;
        $marca->save();

        return response()->json([
             'message' => 'Marca criada com sucesso!',
             'marca' => $marca
        ], 201);
    }

    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if(!$marca){
            return response()->json(['erro' => 'Numero de marca nao existe'], 404) ;
        }

        return response()->json($marca, 200);

        // public function show(Marca $marca)
        // {
        //     return response()->json($marca->load('modelos'), 200);
        // }
    }


    public function update(UpdateMarcaRequest $request, $id)
    {
        $marca = $this->marca->find($id);

        if (!$marca) {
            return response()->json(['erro' => 'Marca não encontrada'], 404);
        }

        $dadosValidados = $request->validated();

        // Se há uma nova imagem, remova a imagem antiga
        if ($request->hasFile('imagem')) {
            Storage::disk('public')->delete($marca->imagem);

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/marcas', 'public');
            $dadosValidados['imagem'] = $imagem_urn;
        } else {
            // Se não há nova imagem, mantenha a imagem atual
            unset($dadosValidados['imagem']); // Remova a imagem dos dados validados
        }

        $marca->update($dadosValidados);

        return response()->json($marca, 200);
    }


    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if(!$marca){
            return response()->json(['erro' => 'Não e possivel realizar a exclusão, mumero de marca nao existe'], 404);
        }

        Storage::disk('public')->delete($marca->imagem);
        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}

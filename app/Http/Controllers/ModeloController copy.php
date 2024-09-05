<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    protected $modelo;
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }


    public function index(Request $request)
    {
        $query = $this->modelo->with('marca');

        // Filtra atributos da marca
        if ($request->has('atributos_marca')) {
            $atributosMarca = $request->input('atributos_marca');
            $query->with('marca:id,' . $atributosMarca);
        }

        // Aplica filtros
        if ($request->has('filtro')) {
            $filtros = explode(';', $request->input('filtro'));
            foreach ($filtros as $filtro) {
                list($campo, $operador, $valor) = explode(':', $filtro);
                $query->where($campo, $operador, $valor);
            }
        }

        // Seleciona atributos específicos
        if ($request->has('atributos')) {
            $atributos = $request->input('atributos');
            $query->selectRaw($atributos);
        }

        $modelos = $query->get();

        return response()->json($modelos, 200);
    }



    public function store(StoreModeloRequest $request)
    {
        $modelo = $this->modelo->create($request->validated());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos','public');
        $modelo->imagem = $imagem_urn;
        $modelo->save();

        return response()->json([
            'msg' => 'Modelo criado com sucesso',
            'modelo' => $modelo
        ], 200);
    }


    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if(!$modelo){
            return response()->json([
                'erro' => 'Modelo nao encontrado',
            ], 404);
        }

        return response()->json($modelo, 200);
    }


    public function update(UpdateModeloRequest $request, $id)
    {
        // Encontra o modelo pelo id
        $modelo = $this->modelo->find($id);

        //ou retorna um erro 404 se não encontrado
        if(!$modelo){
            return response()->json([
                'erro' => 'Modelo nao encontrado',
            ], 404);
        }

        // Obtém os dados validados da requisição
        $dadosValidados = $request->validated();

        // Se há uma nova imagem, remova a imagem antiga
        if ($request->hasFile('imagem')) {
            // Remove a imagem antiga do armazenamento
            Storage::disk('public')->delete($modelo->imagem);

            // Armazena a nova imagem e atualiza o caminho no array de dados validados
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens/modelos', 'public');
            $dadosValidados['imagem'] = $imagem_urn;
        }   else {
            // Se não há nova imagem, remova o campo 'imagem' dos dados validados
            unset($dadosValidados['imagem']);
        }

        // Atualiza o modelo com os dados validados
        $modelo->update($dadosValidados);

        return response()->json($modelo, 200);
    }


    public function destroy($id)
    {

        $modelo = $this->modelo->find($id);

        //remove o arquivo antigo
        Storage::disk('public')->delete($modelo->imagem);
        $modelo->delete();

        return response()->json(['msg' => 'Modelo excluido com sucesso'], 200);
    }
}

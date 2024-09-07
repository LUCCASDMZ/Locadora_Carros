<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function index(Request $request)
    {

        $clienteRepository = new ClienteRepository($this->cliente);

        if($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }

        return response()->json($clienteRepository->getResultado(), 200);
    }


    public function store(StoreClienteRequest $request)
    {
        $cliente = $this->cliente->create($request->validated());


        return response()->json([
            'msg' => 'Usuario registrado com sucesso',
            $cliente
            ],200);
    }


    public function show($id)
    {
        $cliente = $this->cliente->find($id);

        if(!$cliente){
            return response()->json(['error'=> 'Usuario nao encontrado'],404);
        }

        return response()->json([$cliente]);
    }


    public function update(UpdateClienteRequest $request, $id)
    {
        $cliente = $this->cliente->find($id);
        $dadosValidados = $request->validated();
        $cliente->update($dadosValidados);

        return response()->json([
            'msg' => 'Dados do usuario atualizados com sucesso'
        ],202);
    }


    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if(!$cliente){
            return response()->json(['error'=> 'Usuario nao encontrado'],404);
        }

        $cliente->delete();

        return response()->json(['msg'=> 'Usuario deletado com sucesso']);
    }
}

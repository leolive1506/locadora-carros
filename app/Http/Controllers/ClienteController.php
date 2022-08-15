<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;

class ClienteController extends ApiController
{

    private $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder $query
         */
        $query = $this->cliente::query();
        $this->defaultSearch($this->cliente, $request, $query);

        return $this->getFilter($request, $query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        $data = $request->all();
        return $this->cliente::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $cliente_id
     * @return \Illuminate\Http\Response
     */
    public function show($cliente_id)
    {
        return $this->cliente->findOrFail($cliente_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClienteRequest  $request
     * @param  integer  $cliente_id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $cliente_id)
    {
        $cliente = $this->cliente->findOrFail($cliente_id);
        $cliente->update($request->all());

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $cliente_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $cliente_id)
    {
        $this->cliente->destroy($cliente_id);

        return ['message' => 'cliente removido com sucesso'];
    }
}

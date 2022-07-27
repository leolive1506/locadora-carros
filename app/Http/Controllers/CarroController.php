<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarroRequest;
use App\Models\Carro;
use Illuminate\Http\Request;

class CarroController extends ApiController
{
    private $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
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
        $query = $this->carro::query();
        $this->defaultSearch($this->carro, $request, $query);

        // filter relanthioship
        $filterColumsnModelo = $request['columns_modelo'];
        $query->with($filterColumsnModelo ? 'modelo:id,carro_id,' . str_replace(' ', '', $filterColumsnModelo) : 'modelo');

        return $this->getFilter($request, $query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\carroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarroRequest $request)
    {
        $data = $request->all();

        return $this->carro::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $carro_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $carro_id)
    {
        $query = $this->carro::query();
        // filter relanthioship
        $filterColumsnModelo = $request['columns_modelo'];
        $query->with($filterColumsnModelo ? 'modelo:id,marca_id,' . str_replace(' ', '', $filterColumsnModelo) : 'modelo');

        return $query->findOrFail($carro_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CarroRequest  $request
     * @param  integer  $carro_id
     * @return \Illuminate\Http\Response
     */
    public function update(CarroRequest $request, $carro_id)
    {
        $carro = $this->carro->findOrFail($carro_id);
        $data = $request->all();

        $carro->update($data);
        return $carro;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $carro_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $carro_id)
    {
        $carro = $this->carro->findOrFail($carro_id);
        $nameCarro = $carro->nome;

        $carro->delete();
        return ['message' => 'carro ' . $nameCarro . ' removida com sucesso'];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeloRequest;
use App\Models\Modelo;
use App\Services\Storage\StorageService;
use Illuminate\Http\Request;

class ModeloController extends ApiController
{
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
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
        $query = $this->modelo::query();
        $columnsModel = $this->modelo->getCommonColumns();
        $columnsLikeModel = $this->modelo->getLikeColumns();

        foreach ($columnsModel as $column) {
            $this->addFilter($column, $request, $query);
        }

        foreach ($columnsLikeModel as $column) {
            $this->addFilterLike($column, $request, $query);
        }

        $filterColumsnMarca = $request['columns_marca'];
        $query->with($filterColumsnMarca ? 'marca:id,' . str_replace(' ', '', $filterColumsnMarca) : 'marca');

        $this->addFilterByColumn($request, $query);
        return $this->getFilter($request, $query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ModeloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModeloRequest $request)
    {
        $data = $request->all();
        $data['imagem'] = $request->file('imagem')->store('imagens/modelos', 'public');

        return $this->modelo::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $modelo_id
     * @return \Illuminate\Http\Response
     */
    public function show($modelo_id)
    {
        return $this->modelo->with('marca')->findOrFail($modelo_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ModeloRequest  $request
     * @param  integer  $modelo_id
     * @return \Illuminate\Http\Response
     */
    public function update(ModeloRequest $request, $modelo_id)
    {
        $modelo = $this->modelo->findOrFail($modelo_id);
        $data = $request->all();

        if (! empty($data['imagem'])) {
            $data['imagem'] = $request->file('imagem')->store('imagens/modelos', 'public');
            StorageService::delete($modelo->imagem);
        }

        $modelo->update($data);
        return $modelo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $modelo_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $modelo_id)
    {
        $modelo = $this->modelo->findOrFail($modelo_id);
        $namemodelo = $modelo->nome;

        StorageService::delete($modelo->imagem);
        $modelo->delete();

        return ['message' => 'Modelo ' . $namemodelo . ' removido com sucesso'];
    }
}

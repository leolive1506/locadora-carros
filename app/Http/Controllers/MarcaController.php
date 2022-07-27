<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use App\Services\Storage\StorageService;
use Illuminate\Http\Request;
class MarcaController extends ApiController
{
    private $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
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
        $query = $this->marca::query();
        $this->defaultSearch($this->marca, $request, $query);

        // filter relanthioship
        $filterColumsnModelos = $request['columns_modelos'];
        $query->with($filterColumsnModelos ? 'modelos:id,marca_id,' . str_replace(' ', '', $filterColumsnModelos) : 'modelos');

        return $this->getFilter($request, $query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaRequest $request)
    {
        $data = $request->all();
        $data['imagem'] = $request->file('imagem')->store('imagens/marcas', 'public');

        return $this->marca::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $marca_id
     * @return \Illuminate\Http\Response
     */
    public function show($marca_id)
    {
        return $this->marca->findOrFail($marca_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MarcaRequest  $request
     * @param  integer  $marca_id
     * @return \Illuminate\Http\Response
     */
    public function update(MarcaRequest $request, $marca_id)
    {
        $marca = $this->marca->findOrFail($marca_id);
        $data = $request->all();

        if (! empty($data['imagem'])) {
            $data['imagem'] = $request->file('imagem')->store('imagens/marcas', 'public');
            StorageService::delete($marca->imagem);
        }

        $marca->update($data);
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $marca_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $marca_id)
    {
        $marca = $this->marca->findOrFail($marca_id);
        $nameMarca = $marca->nome;

        StorageService::delete($marca->imagem);
        $marca->delete();

        return ['message' => 'Marca ' . $nameMarca . ' removida com sucesso'];
    }
}

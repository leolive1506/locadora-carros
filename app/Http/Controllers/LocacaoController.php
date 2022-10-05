<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LocacaoRequest;
use App\Models\Locacao;

class LocacaoController extends ApiController
{
    private $locacao;

    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
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
        $query = $this->locacao::query();
        $this->defaultSearch($this->locacao, $request, $query);

        // // filter relanthioship
        // $filterColumsnModelos = $request['columns_modelos'];
        // $query->with($filterColumsnModelos ? 'modelos:id,locacao_id,' . str_replace(' ', '', $filterColumsnModelos) : 'modelos');

        return $this->getFilter($request, $query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\locacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocacaoRequest $request)
    {
        $data = $request->all();
        $data['imagem'] = $request->file('imagem')->store('imagens/locacaos', 'public');

        return $this->locacao::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $locacao_id
     * @return \Illuminate\Http\Response
     */
    public function show($locacao_id)
    {
        return $this->locacao->findOrFail($locacao_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LocacaoRequest  $request
     * @param  integer  $locacao_id
     * @return \Illuminate\Http\Response
     */
    public function update(LocacaoRequest $request, $locacao_id)
    {
        $locacao = $this->locacao->findOrFail($locacao_id);
        $locacao->update($request->all());

        return $locacao;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $locacao_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $locacao_id)
    {
        $this->locacao->destroy($locacao_id);
        return ['message' => 'locação removida com sucesso'];
    }
}

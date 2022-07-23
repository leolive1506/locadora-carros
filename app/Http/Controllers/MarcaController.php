<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
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
    public function index()
    {
        $marcas = $this->marca::orderBy('id', 'asc')->paginate(20);
        return $marcas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->marca::create($request->all());
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
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $marca_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $marca_id)
    {
        $marca = $this->marca->findOrFail($marca_id);
        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $marca_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($marca_id)
    {
        $marca = $this->marca->findOrFail($marca_id);
        $nameMarca = $marca->nome;
        $marca->delete();
        return ['message' => 'Marca ' . $nameMarca . ' removida com sucesso'];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Exception;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr;

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
        $marcas = $this->marca::orderBy('id', 'desc')->paginate(20);
        return $marcas;
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
        $data['imagem'] = $request->file('imagem')->store('imagens', 'public');

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
            $data['imagem'] = $request->file('imagem')->store('imagens', 'public');
            $this->deleteImage($marca->imagem);
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

        $this->deleteImage($marca->imagem);
        $marca->delete();

        return ['message' => 'Marca ' . $nameMarca . ' removida com sucesso'];
    }

    private function deleteImage($path)
    {
        try {
            Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            return response()->json(['message' => 'error delete', 'exception' => $e]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $fillable = ['nome', 'imagem'];

    public static function rules(int $marcaId = null)
    {
        return [
            'nome' => 'required|string|unique:marcas,nome,' . $marcaId .'|max:140',
            'imagem' => $marcaId ? 'nullable' : 'required' . '|file|mimes:png,jpg,jpeg'
        ];
    }

    public static function messagesValidation()
    {
        return [
            'nome.required' => 'O titulo não pode ser nulo',
            'nome.unique' => 'Essa marca já existe',
            'imagem.required' => 'A imagem não pode ser nula',
        ];
    }
}

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
            'imagem' => 'required|string|max:255'
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

    public function attributes()
    {
        return $this;
    }

    public function model()
    {
        return $this;
    }
}

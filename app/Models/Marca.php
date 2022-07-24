<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $fillable = ['nome', 'imagem'];

    public static function rules()
    {
        return [
            'nome' => 'required|string|max:140',
            'imagem' => 'required|string|max:255'
        ];
    }

    public static function messagesValidation()
    {
        return [
            'nome.required' => 'O titulo não pode ser nulo',
            'imagem.required' => 'A imagem não pode ser nula',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $fillable = ['nome', 'imagem'];

    public static function rules(int $marca_id = null)
    {
        return [
            'nome' => 'required|string|unique:marcas,nome,' . $marca_id .'|max:140',
            'imagem' => $marca_id ? 'nullable' : 'required' . '|file|mimes:png,jpg,jpeg'
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

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'marca_id');
    }
}

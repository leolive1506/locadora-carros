<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends ApiModel
{
    use HasFactory;
    protected $table = 'modelos';
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];
    protected $likeFiltersPropertys = ['nome'];

    // rules
    public static function rules(int $modelo_id = null)
    {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|string|unique:modelos,nome,' . $modelo_id .'|max:140',
            'imagem' => $modelo_id ? 'nullable' : 'required' . '|file|mimes:png,jpg,jpeg',
            'numero_portas' => 'required|integer|digits_between:1,8', // (1,2,3,4,5,6,7,8)
            'lugares' => 'required|integer|digits_between:1,5',
            'air_bag' => 'required|boolean', // true, false, 0, 1
            'abs' => 'required|boolean'
        ];
    }

    // relationship
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
}

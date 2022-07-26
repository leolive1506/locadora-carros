<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carro extends ApiModel
{
    use HasFactory;
    protected $table = 'carros';
    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    protected $likeColumns = ['placa'];

    public static function rules()
    {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required|boolean',
            'km' => 'required|integer',
        ];
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }
}

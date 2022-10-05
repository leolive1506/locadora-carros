<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends ApiModel
{
    use HasFactory;
    protected $table = 'locacoes';
    protected $fillable = ['cliente_id', 'carro_id', 'data_inicio_periodo', 'data_final_previsao_periodo', 'data_final_realizado_periodo', 'valor_diaria', 'km_inicial', 'km_final'];

    // rules
    public static function rules()
    {
        return [
            'cliente_id' => 'required|integer',
            'carro_id' => 'required||integer',
            'data_inicio_periodo' => 'required',
            'data_final_previsao_periodo' => 'required',
            'data_final_realizado_periodo' => 'required',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|numeric',
            'km_final' => 'required|numeric'
        ];
    }
}

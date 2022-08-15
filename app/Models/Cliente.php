<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends ApiModel
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['nome'];
    protected $likeColumns = ['nome'];

    public static function rules()
    {
        return [
            'nome' => 'required|max:140',
        ];
    }
}

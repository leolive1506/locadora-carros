<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|max:140',
            'imagem' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'A title is required',
            'imagem.required' => 'A imagem não pode ser nula',
        ];
    }


}

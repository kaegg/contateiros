<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstalacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "codigo" => "required|string|max:10|unique:App\Models\Atividade,codigo",
            "nome"   => "required|string|max:255",
            "ativo"  => "required|boolean"
        ];
    }

    public function messages(): array
    {
        return [
            "codigo.required" => "O código deve ser informado.",
            "codigo.string"   => "O código deve ser um texto.",
            "codigo.max"      => "O código deve ter no máximo 10 caracteres.",
            "codigo.unique"   => "O código informado já está em uso.",

            "nome.required"   => "O nome deve ser informado.",
            "nome.string"     => "O nome deve ser um texto.",
            "nome.max"        => "O nome deve ter no máximo 255 caracteres.",

            "ativo.required"  => "O campo ativo deve ser informado.",
            "ativo.boolean"   => "O campo ativo deve ser verdadeiro ou falso.",
        ];
    }
}

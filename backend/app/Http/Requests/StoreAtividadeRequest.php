<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtividadeRequest extends FormRequest
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
            "icone"  => "required|file|mimes:jpeg,jpg,png,svg|max:2048", // até 2MB
            "ativo"  => "required|boolean",
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

            "icone.required"  => "O ícone deve ser enviado.",
            "icone.file"      => "O ícone deve ser um arquivo válido.",
            "icone.mimes"     => "O ícone deve estar no formato JPEG, JPG, PNG ou SVG.",
            "icone.max"       => "O ícone deve ter no máximo 2 MB.",

            "ativo.required"  => "O campo ativo deve ser informado.",
            "ativo.boolean"   => "O campo ativo deve ser verdadeiro ou falso.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAtividadeRequest extends FormRequest
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
        $atividadeRoute = $this->route('atividade');
$atividadeId = is_object($atividadeRoute) ? $atividadeRoute->id : $atividadeRoute;
        
        return [
            "codigo" => [
                "required",
                "string",
                "max:10",
                Rule::unique('atividade', 'codigo')->ignore($atividadeId)
            ],
            "nome"   => "required|string|max:255",
            "icone"  => "nullable|file|mimes:jpeg,jpg,png,svg|max:2048", // opcional na atualização
            "ativo"  => "required|boolean",
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "codigo.required" => "O código deve ser informado.",
            "codigo.string"   => "O código deve ser um texto.",
            "codigo.max"      => "O código deve ter no máximo 10 caracteres.",
            "codigo.unique"   => "Este código já está em uso.",

            "nome.required" => "O nome deve ser informado.",
            "nome.string"   => "O nome deve ser um texto.",
            "nome.max"      => "O nome deve ter no máximo 255 caracteres.",

            "icone.file"      => "O ícone deve ser um arquivo válido.",
            "icone.mimes"     => "O ícone deve ser um arquivo do tipo: jpeg, jpg, png, svg.",
            "icone.max"       => "O ícone deve ter no máximo 2MB.",

            "ativo.required" => "O status ativo deve ser informado.",
            "ativo.boolean"  => "O status ativo deve ser verdadeiro ou falso.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalImagemRequest extends FormRequest
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
            "id_local" => "required|integer|exists:local,id",
            "imagem" => "required|string", // Base64 da imagem
            "ativo" => "required|boolean",
        ];
    }

    public function messages(): array
    {
        return [
            "id_local.required" => "O ID do local deve ser informado.",
            "id_local.integer" => "O ID do local deve ser um número inteiro.",
            "id_local.exists" => "O local informado não existe.",

            "imagem.required" => "A imagem deve ser informada.",
            "imagem.string" => "A imagem deve ser uma string (Base64).",

            "ativo.required" => "O campo ativo deve ser informado.",
            "ativo.boolean" => "O campo ativo deve ser verdadeiro ou falso.",
        ];
    }
}

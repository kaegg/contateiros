<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalAvaliacaoRequest extends FormRequest
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
            "id_usuario" => "required|integer|exists:usuario,id",
            "avaliacao" => "required|integer|min:1|max:5",
            "comentario" => "nullable|string|max:1000",
            "ativo" => "required|boolean",
        ];
    }

    public function messages(): array
    {
        return [
            "id_local.required" => "O ID do local deve ser informado.",
            "id_local.integer" => "O ID do local deve ser um número inteiro.",
            "id_local.exists" => "O local informado não existe.",

            "id_usuario.required" => "O ID do usuário deve ser informado.",
            "id_usuario.integer" => "O ID do usuário deve ser um número inteiro.",
            "id_usuario.exists" => "O usuário informado não existe.",

            "avaliacao.required" => "A avaliação deve ser informada.",
            "avaliacao.integer" => "A avaliação deve ser um número inteiro.",
            "avaliacao.min" => "A avaliação deve ser pelo menos 1.",
            "avaliacao.max" => "A avaliação deve ser no máximo 5.",

            "comentario.string" => "O comentário deve ser um texto.",
            "comentario.max" => "O comentário deve ter no máximo 1000 caracteres.",

            "ativo.required" => "O campo ativo deve ser informado.",
            "ativo.boolean" => "O campo ativo deve ser verdadeiro ou falso.",
        ];
    }
}

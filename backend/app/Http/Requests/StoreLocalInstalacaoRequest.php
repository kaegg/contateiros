<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalInstalacaoRequest extends FormRequest
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
            "id_instalacao" => "required|integer|exists:instalacao,id",
            "ativo" => "required|boolean",
        ];
    }

    public function messages(): array
    {
        return [
            "id_local.required" => "O ID do local deve ser informado.",
            "id_local.integer" => "O ID do local deve ser um número inteiro.",
            "id_local.exists" => "O local informado não existe.",

            "id_instalacao.required" => "O ID da instalação deve ser informado.",
            "id_instalacao.integer" => "O ID da instalação deve ser um número inteiro.",
            "id_instalacao.exists" => "A instalação informada não existe.",

            "ativo.required" => "O campo ativo deve ser informado.",
            "ativo.boolean" => "O campo ativo deve ser verdadeiro ou falso.",
        ];
    }
}

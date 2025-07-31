<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalRequest extends FormRequest
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
            "nome" => "required|string|max:255",
            "cidade" => "required|string|max:255",
            "estado" => "required|string|max:2",
            "nome_proprietario" => "required|string|max:255",
            "telefone_proprietario" => "required|string|max:25",
            "descricao" => "nullable|string",
            "capacidade_pessoas" => "required|integer|min:1",
            "id_usuario_criacao" => "required|integer|exists:usuario,id",
            "id_usuario_alteracao" => "nullable|integer|exists:usuario,id",
            "ativo" => "required|boolean",
            "atividades" => "nullable|array",
            "atividades.*" => "integer|exists:atividade,id",
            "instalacoes" => "nullable|array",
            "instalacoes.*" => "integer|exists:instalacao,id",
        ];
    }

    public function messages(): array
    {
        return [
            "nome.required" => "O nome do local deve ser informado.",
            "nome.string" => "O nome do local deve ser um texto.",
            "nome.max" => "O nome do local deve ter no máximo 255 caracteres.",

            "cidade.required" => "A cidade deve ser informada.",
            "cidade.string" => "A cidade deve ser um texto.",
            "cidade.max" => "A cidade deve ter no máximo 255 caracteres.",

            "estado.required" => "O estado deve ser informado.",
            "estado.string" => "O estado deve ser um texto.",
            "estado.max" => "O estado deve ter no máximo 2 caracteres.",

            "nome_proprietario.required" => "O nome do proprietário deve ser informado.",
            "nome_proprietario.string" => "O nome do proprietário deve ser um texto.",
            "nome_proprietario.max" => "O nome do proprietário deve ter no máximo 255 caracteres.",

            "telefone_proprietario.required" => "O telefone do proprietário deve ser informado.",
            "telefone_proprietario.string" => "O telefone do proprietário deve ser um texto.",
            "telefone_proprietario.max" => "O telefone do proprietário deve ter no máximo 25 caracteres.",

            "descricao.string" => "A descrição deve ser um texto.",

            "capacidade_pessoas.required" => "A capacidade de pessoas deve ser informada.",
            "capacidade_pessoas.integer" => "A capacidade de pessoas deve ser um número inteiro.",
            "capacidade_pessoas.min" => "A capacidade de pessoas deve ser pelo menos 1.",

            "id_usuario_criacao.required" => "O usuário de criação deve ser informado.",
            "id_usuario_criacao.integer" => "O usuário de criação deve ser um ID válido.",
            "id_usuario_criacao.exists" => "O usuário de criação informado não existe.",

            "id_usuario_alteracao.integer" => "O usuário de alteração deve ser um ID válido.",
            "id_usuario_alteracao.exists" => "O usuário de alteração informado não existe.",

            "ativo.required" => "O campo ativo deve ser informado.",
            "ativo.boolean" => "O campo ativo deve ser verdadeiro ou falso.",

            "atividades.array" => "As atividades devem ser fornecidas em formato de lista.",
            "atividades.*.integer" => "Cada atividade deve ser um ID válido.",
            "atividades.*.exists" => "Uma das atividades informadas não existe.",

            "instalacoes.array" => "As instalações devem ser fornecidas em formato de lista.",
            "instalacoes.*.integer" => "Cada instalação deve ser um ID válido.",
            "instalacoes.*.exists" => "Uma das instalações informadas não existe.",
        ];
    }
}

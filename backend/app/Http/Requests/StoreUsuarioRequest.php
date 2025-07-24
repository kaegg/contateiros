<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
        $usuarioId = $this->route('usuario') ? $this->route('usuario')->id : null;
        return [
            "nome"      => "required|string|max:255",
            "usuario"   => "required|string|max:50|unique:App\\Models\\Usuario,usuario," . $usuarioId,
            "telefone"  => "required|string|max:25",
            "email"     => "required|email|max:255",
            "id_funcao" => "required|integer",
            "id_secao"  => "required|integer",
            "ativo"     => "required|boolean",
        ];
    }

    public function messages(): array
    {
        return [
            "nome.required"      => "O nome deve ser informado.",
            "nome.string"        => "O nome deve ser um texto.",
            "nome.max"           => "O nome deve ter no máximo 255 caracteres.",

            "usuario.required"   => "O usuário deve ser informado.",
            "usuario.string"     => "O usuário deve ser um texto.",
            "usuario.max"        => "O usuário deve ter no máximo 50 caracteres.",
            "usuario.unique"     => "O nome de usuário já está em uso.",

            "telefone.required"  => "O telefone deve ser informado.",
            "telefone.string"    => "O telefone deve ser um texto.",
            "telefone.max"       => "O telefone deve ter no máximo 25 caracteres.",

            "email.required"     => "O email deve ser informado.",
            "email.email"        => "O email deve ser email válido.",
            "email.max"          => "O email deve ter no máximo 255 caracteres.",
            
            "id_funcao.required" => "A função deve ser informada.",
            "id_funcao.integer"  => "A função informada deve ser seu id.",

            "id_secao.required"  => "A seção deve ser informada.",
            "id_secao.integer"   => "A seção informada deve ser seu id.",

            "ativo.required"     => "O campo ativo deve ser informado." ,
            "ativo.boolean"      => "O campo ativo deve verdadeiro ou falso.",
        ];
    }
}

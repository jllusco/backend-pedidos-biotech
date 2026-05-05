<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateComunicadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !!$this->user();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'fecha_inicio' => $this->fechaInicio ?? $this->fecha_inicio,
            'fecha_fin' => $this->fechaFin ?? $this->fecha_fin,
        ]);

        if ($this->audiencia === 'GLOBAL') {
            $this->merge([
                'usuarios' => []
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'titulo'=> ['required','string'],
            'descripcion' => ['required', 'string', 'min:30'],
            'tipo'=>['required'],
            'audiencia' => ['required', 'in:GLOBAL,USUARIO'],

            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],

            'imagen' => ['nullable', 'file', 'image'],
            'documento' => ['nullable', 'file'],

            'usuarios' => [
                'required_if:audiencia,USUARIO',
                'array'
            ],
            'usuarios.*' => [
                'uuid',
                'distinct',
                'exists:users,id'
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error($validator->errors()->first())
        );
    }
}

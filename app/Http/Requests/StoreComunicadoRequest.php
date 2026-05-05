<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreComunicadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!$this->user();
    }

     protected function prepareForValidation()
    {
        $this->merge([
            'fecha_inicio'=>$this->fechaInicio,
            'fecha_fin'=>$this->fechaFin,
        ]);
        if ($this->audiencia === 'GLOBAL') {
            $this->merge([
                'usuarios' => null
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo'=> ['required','string'],
            'descripcion' => ['required', 'string', 'min:30'],
            'tipo'=>['required'],
            'audiencia' => ['required', 'in:GLOBAL,USUARIO'],
            'fecha_inicio'=>['required'],
            'fecha_fin'=>['required'],
            'usuarios' => [
                'nullable',
                'array',
                'required_if:audiencia,USUARIO',
                'min:1'
            ],
            'usuarios.*' => [
                'required',
                'uuid',
                'distinct',
                'exists:users,id'
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }
}

<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreParametroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo'=>'required|unique:parametro',
            'nombre'=>'required',
            'descripcion'=>'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }

    public function messages(){

        return [
            'codigo.unique' =>'El codigo ya se encuentra registrado',
            'nombre.required' => 'El campo nombre es requerido',
        ];

    }
}

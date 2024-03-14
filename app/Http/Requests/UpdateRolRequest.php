<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateRolRequest extends FormRequest
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
        $method = $this->method();
        if($method==='PUT'){
            return [
                'codigo'=>'sometimes|required',
                'nombre'=>'required',
                'descripcion'=>'required'
            ];
        }else{
            return [
                'codigo'=>'sometimes|required',
                'nombre'=>'sometimes|required',
                'descripcion'=>'sometimes|required'
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error de validación',
            'errors' => $validator->errors(),
        ]));
    }

    public function messages(){

        return [
            'codigo.unique' =>'El codigo ya se encuentra registrado',
            'nombre.required' => 'El campo nombre es requerido',
        ];

    }
}

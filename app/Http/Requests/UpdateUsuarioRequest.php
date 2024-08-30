<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUsuarioRequest extends FormRequest
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
            'name'=>$this->usuario,
            'password'=>$this->contrasena,
            'numero_documento'=>$this->numeroDocumento,
            'primer_apellido'=>$this->primerApellido,
            'segundo_apellido'=>$this->segundoApellido,
            'correo_electronico'=>$this->correoElectronico,
            'rol_id'=>$this->rolId,
            'lista_precio_id'=>$this->listaPrecioId
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','unique:users','min:4'],
            'numeroDocumento' => ['required','min:4'],
            'nombres' => ['required'],
            'primerApellido'=>['nullable'],
            'segundoApellido'=>['nullable'],
            'correoElectronico'=>['required'],
            'celular'=>['required'],
            'estado'=>['required'],
            'rolId'=>['required']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }
}

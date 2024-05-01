<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductoRequest extends FormRequest
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
            'categoria_id'=>$this->categoriaId,
            'proveedor_id'=>$this->proveedorId,
            'presentacion_id'=>$this->presentacionId,
            'registro_sanitario_id'=>$this->registroSanitarioId,
            'precio_exwork'=>$this->precioExwork
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
            'codigo' => ['required','string','min:3','max:50'],
            'nombre' =>  ['required','string','max:100'],
            'descripcion' => ['required','string','min:10'],
            'imagen'=>['sometimes','required','file','mimes:jpeg,png','max:6144'],
            'tipo'=>['required'],
            'proveedorId'=>['required'],
            'presentacionId'=>['required'],
            'precioExwork'=>['required']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParametroRequest extends FormRequest
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
        $method = $this->method();
        if($method === 'PUT'){
            return [
                'codigo'=>'required',
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
}

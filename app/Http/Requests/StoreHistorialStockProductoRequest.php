<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 22/7/2024
 * Time: 21:37
 */

namespace App\Http\Requests;


use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreHistorialStockProductoRequest extends FormRequest
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
            'producto_id'=>$this->productoId,
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
            'productoId' => ['required'],
            'tipo' => ['required'],
            'cantidad' => ['required'],
            'descripcion'=>['required'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }
}
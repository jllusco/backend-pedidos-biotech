<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 10:09
 */

namespace App\Http\Requests;


use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMenuRequest extends FormRequest
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
        //dump($this->all());die;
        return [
            'nombre' => ['required'],
            'ruta' => ['required'],
            'icono' => ['required'],
            'orden'=>['required'],
            'estado'=>['required'],
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }

}
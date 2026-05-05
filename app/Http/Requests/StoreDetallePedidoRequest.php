<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class StoreDetallePedidoRequest extends FormRequest
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
            'pedido_id'=>$this->pedidoId,
            'producto_id'=>$this->id,
            'cantidad'=>$this->cantidadSolicitada,
            'tipo_producto'=>$this->tipo,
            'precio'=>$this->precioUnitario,
            'monto'=>intval($this->cantidadSolicitada)* doubleval($this->precioUnitario)
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
            'pedido_id'     => ['required', 'uuid', 'exists:pedido,id'],
            'producto_id'   => [
                'required',
                'uuid', 
                'exists:producto,id',
                \Illuminate\Validation\Rule::unique('detalle_pedido')
                ->where('pedido_id', $this->pedido_id)
                ->whereNull('deleted_at')
            ],
            'cantidad'      => ['required', 'numeric', 'min:1'],
            'tipo_producto' => ['required', 'string', 'max:50'],
            'precio'        => ['required', 'numeric', 'min:0'],
            'monto'         => ['required', 'numeric', 'min:0']
        ];
    }

    public function messages(): array
    {
        return [
            'pedido_id.exists'   => 'El pedido seleccionado no es válido.',
            'producto_id.unique' => 'Este producto ya ha sido agregado al pedido.',
            'producto_id.exists' => 'El producto no existe en nuestro catálogo.',
            'cantidad.min'       => 'La cantidad debe ser al menos 1.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first()));
    }
}

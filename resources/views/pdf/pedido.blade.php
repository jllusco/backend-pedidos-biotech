<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{public_path('css/bootstrap.min.css') }}"/>
    <style>
        .container{
            margin-right: 2cm !important;
            margin-left: 1.5cm !important;
        }
        .text-title-primary{
            color: #014b81;
            font-weight: bold;
        }
        .subtitulo{
            margin-top: 30px;
        }
        dd{
            margin-bottom: 10px;
        }
        .pedido{
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-3">
            <img src="{{ $logo }}" alt="Imagen en Base64" width="200px">
        </div>
        <div class="col-xs-9 text-right">
            <div class="h5 text-title-primary">ALM-01.R1/2024</div>
            <div class="h5 text-title-primary">{{ $pedido->codigo }}</div>
        </div>
    </div>
    <div class="row justify-center titulo">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6 text-center">
            <div class="h4 text-title-primary">ORDEN DE PEDIDO A ALMACEN</div>
        </div>
        <div class="col-xs-3">

        </div>
    </div>
    <div class="row pedido">
        <div class="col-xs-4">
            <dt>Fecha:</dt><dd>{{$pedido->createdAt}}</dd>
        </div>
        <div class="col-xs-4">
            <dt>Ciudad:</dt><dd>{{$pedido->ciudad}}</dd>
        </div>
        <div class="col-xs-4">
            <dt>Institución:</dt><dd>{{$pedido->institucion}}</dd>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <dt>Asunto:</dt><dd>{{$pedido->asunto}}</dd>
        </div>
        @if($pedido->comentario)
        <div class="col-xs-6">
            <dt>Comentario:</dt><dd>{{$pedido->comentario}}</dd>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xs-4">
            <dt>Contacto:</dt><dd>{{$pedido->contacto->nombre}}</dd>
        </div>
        <div class="col-xs-4">
            <dt>Cargo:</dt><dd>{{$pedido->contacto->cargo}}</dd>
        </div>
        <div class="col-xs-4">
            <dt>Celular:</dt><dd>{{$pedido->contacto->celular}}</dd>
        </div>
    </div>
    <div class="row subtitulo">
        <div class="col-xs-12 h5 text-title-primary">
            Lista de productos
        </div>
    </div>
    <div class="row detalle">
        <div class="col-xs-12">
            <table class="table table-striped-pdf">
                <thead>
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Descripcion</th>
                        <th class="text-center">Unidad</th>
                        <th class="text-center">Cantidad</th>
                        @if($esOperador)
                            <th class="text-center">Precio</th>
                            <th class="text-center">Sub total</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach( $productos as $producto)
                        <tr>
                            <td class="text-center">{{$producto->producto->codigo}}</td>
                            <td>{{$producto->producto->nombre}} - {{$producto->producto->presentacion->nombre}}</td>
                            <td class="text-center">{{$producto->producto->unidad}}</td>
                            <td class="text-center">{{$producto->cantidad}}</td>
                            @if($esOperador)
                                <td class="text-right">{{$producto->precio}}</td>
                                <td class="text-right">{{$producto->monto}}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
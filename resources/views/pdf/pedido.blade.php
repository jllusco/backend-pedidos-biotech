<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{public_path('css/bootstrap.min.css') }}"/>
    <style>
        body{
            margin-right: 2cm;
            margin-left: 1.5cm;
        }
        .text-title-primary{
            color: #014b81;
            font-weight: bold;
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
        <div class="col-xs-4 col-xs-offset-1">
            <dt>Fecha:</dt><dd>{{$pedido->createdAt}}</dd>
            <dt>Ciudad:</dt><dd>{{$pedido->ciudad}}</dd>
            <dt>Institución:</dt><dd>{{$pedido->institucion}}</dd>
            <dt>Asunto:</dt><dd>{{$pedido->asunto}}</dd>
            <dt>Comentario:</dt><dd>{{$pedido->comentario}}</dd>
        </div>
        <div class="col-xs-4 col-xs-offset-1">
            <dt>Contacto:</dt><dd>{{$pedido->contacto->nombre}}</dd>
            <dt>Cargo:</dt><dd>{{$pedido->contacto->cargo}}</dd>
            <dt>Celular:</dt><dd>{{$pedido->contacto->celular}}</dd>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach( $productos as $producto)
                        <tr>
                            <td class="text-center">{{$producto->producto->codigo}}</td>
                            <td>{{$producto->producto->nombre}} - {{$producto->producto->presentacion->nombre}}</td>
                            <td class="text-center">{{$producto->producto->unidad}}</td>
                            <td class="text-center">{{$producto->cantidad}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
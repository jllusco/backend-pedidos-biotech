<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\Biotech\DetallePedidoCollection;
use App\Http\Resources\Biotech\PedidoCollection;
use App\Http\Resources\Biotech\PedidoResource;
use App\Jobs\SendNotificationPedidoRealizadoJob;
use App\Models\Cronograma;
use App\Models\DetallePedido;
use App\Models\HistorialEstadoPedido;
use App\Models\HistorialStockProducto;
use App\Models\Pedido;
use App\Models\Producto;
use App\Repository\DetallePedidoRepository;
use App\Repository\HistorialEstadoPedidoRepository;
use App\Repository\ListaPrecioProductoRepository;
use App\Repository\PedidoRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PedidoController extends Controller
{
    private $pedidoRepository;
    private $detallePedidoRepository;
    private $historialEstadoPedidoRepository;
    private $listaPrecioProductoRepository;

    public function __construct(PedidoRepository $pedidoRepository,
                                DetallePedidoRepository $detallePedidoRepository,
                                HistorialEstadoPedidoRepository $historialEstadoPedidoRepository,
                                ListaPrecioProductoRepository $listaPrecioProductoRepository
    )
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->detallePedidoRepository = $detallePedidoRepository;
        $this->historialEstadoPedidoRepository = $historialEstadoPedidoRepository;
        $this->listaPrecioProductoRepository = $listaPrecioProductoRepository;
    }

    public function index(Request $request){
        try {
            $params = $request->query->all();
            if(!$request->user()->tokenCan('pedidos:listar:todo')){
                $params['created_by'] = $request->user()->id;
            }
            $pedidos = $this->pedidoRepository->findAll($params);
            return ApiResponse::success( new PedidoCollection($pedidos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }


    public function store(StorePedidoRequest $request){
        try {
            $datos = $request->request->all();
            $productos = $request->get('productos');
            if(count($productos)===0){
                return ApiResponse::error('El pedido debe tener al menos un producto');
            }
            $usuario = $request->user();
            $montoTotal = $this->getMontoTotal($productos);
            $datos['monto_total'] = $montoTotal;
            $datos['contacto'] = json_encode($datos['contacto']);
            $datos['lista_precio_id'] = $usuario->lista_precio_id;
            $datos['usuario_solicitante_id'] = $usuario->id;
            $datos['nombre_usuario_solicitante'] = trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido);
            $pedido = Pedido::create($datos);
            foreach ($productos as $producto) {
                DetallePedido::create([
                    'pedido_id'=>$pedido->id,
                    'producto_id'=>$producto['id'],
                    'cantidad'=>$producto['cantidadSolicitada'],
                    'tipo_producto'=>$producto['tipo'],
                    'precio'=>$producto['precioUnitario'],
                    'monto'=>intval($producto['cantidadSolicitada'])* doubleval($producto['precioUnitario']),
                    'created_by'=>$request->user()->id
                ]);
            }
            HistorialEstadoPedido::create([
                'pedido_id'=>$pedido->id,
                'estado'=>'CREADO',
                'nombre_usuario'=>trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido),
                'rol_usuario'=>$usuario->rol->nombre
            ]);
            return ApiResponse::success(new PedidoResource($pedido));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(Pedido $pedido){
        try {
            $productos = $this->detallePedidoRepository->getByPedido($pedido->id);
            return ApiResponse::success([
                'pedido'=>new PedidoResource($pedido),
                'productos'=>new DetallePedidoCollection($productos)
            ]);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function generarCodigo(){
        $meses = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
        $fechaActual = Carbon::now();
        $cantidadActual = $this->pedidoRepository->getCantidad($fechaActual->year,$fechaActual->month);
        $numero = str_pad($cantidadActual+1,3,'0',STR_PAD_LEFT);
        $mes=$meses[$fechaActual->format('n')-1];
        return $mes.$numero;
    }

    public function confirmar(Pedido $pedido,Request $request){
        try {
            if($pedido->estado !== 'CREADO'){
                return ApiResponse::error('El pedido se encuentra en estado '.$pedido->estado);
            }
            $fechaActual = (Carbon::now())->setTime(0,0,0,0);
            $cronogramaActual = Cronograma::query()->where('mes','=',intval($fechaActual->format('m')))->where('estado','=','ACTIVO')->first();
            if(!$cronogramaActual){
                return ApiResponse::error('No se tiene habilitado una fecha para el mes en curso');
            }
            $fechaIncio = Carbon::create($fechaActual->format('Y'),$cronogramaActual->mes,$cronogramaActual->inicio);
            $fechaFin = Carbon::create($fechaActual->format('Y'),$cronogramaActual->mes,$cronogramaActual->fin);
            if($fechaIncio>$fechaActual or $fechaFin<$fechaActual) {
                return ApiResponse::error('No se puede realizar el pedido, fecha actual fuera del rango permitido');
            }
            $usuario = $request->user();
            if($pedido->usuario_solicitante_id !== $usuario->id){
                return ApiResponse::error('El pedido solo puede ser confirmado por el usuario '.$pedido->nombre_usuario_solicitante );
            }
            $datos=[
                'codigo'=>$this->generarCodigo(),
                'fecha'=>Carbon::now(),
                'estado'=>'CONFIRMADO',
            ];
            $pedido->update($datos);
            $productos = $this->detallePedidoRepository->getByPedido($pedido->id);
            foreach ($productos as $producto) {
                $productoOriginal = $producto->producto;
                if($productoOriginal->cantidad_actual>0){
                    $saldoStock = $producto->cantidad - $productoOriginal->cantidad_actual;
                    $nuevoStock = 0;
                    $cantidadEntrega = $productoOriginal->cantidad_actual;
                    if($saldoStock<0){
                        $nuevoStock = $saldoStock* -1;
                        $cantidadEntrega = $productoOriginal->cantidad_actual - $nuevoStock;
                    }
                    HistorialStockProducto::create([
                        'tipo'=>'EGRESO',
                        'producto_id'=>$productoOriginal->id,
                        'descripcion'=>"Entrega inmediata para el pedido confirmado $pedido->codigo",
                        'cantidad'=>$cantidadEntrega,
                        'saldo'=>$nuevoStock,
                        'detalle_pedido_id'=>$producto->id
                    ]);
                    $productoOriginal->update(['cantidad_actual'=>$nuevoStock]);
                    $producto->update(['cantidad_entrega_inmediata'=>$cantidadEntrega]);
                }
            }
            HistorialEstadoPedido::create([
                'pedido_id'=>$pedido->id,
                'estado'=>'CONFIRMADO',
                'nombre_usuario'=>trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido),
                'rol_usuario'=>$usuario->rol->nombre
            ]);

            SendNotificationPedidoRealizadoJob::dispatch($pedido->estado,$usuario->id,$pedido->id);

            return ApiResponse::success(new PedidoResource($pedido));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function cancelar(Pedido $pedido,Request $request){
        try {
            if(!in_array($pedido->estado,['CREADO','PENDIENTE'])){
                return ApiResponse::error('El pedido se encuentra en estado '.$pedido->estado);
            }
            $usuario = $request->user();
            $nombreUsuario = trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido);
            if($pedido->usuario_solicitante_id !== $usuario->id){
                return ApiResponse::error('El pedido solo puede ser cancelado por el usuario '.$nombreUsuario );
            }
            $datos=[
                'codigo'=>$this->generarCodigo(),
                'fecha'=>Carbon::now(),
                'estado'=>'CANCELADO',
            ];
            $pedido->update($datos);
            HistorialEstadoPedido::create([
                'pedido_id'=>$pedido->id,
                'estado'=>'CANCELADO',
                'nombre_usuario'=>trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido),
                'rol_usuario'=>$usuario->rol->nombre
            ]);

            SendNotificationPedidoRealizadoJob::dispatch($pedido->estado,$usuario->id,$pedido->id);

            return ApiResponse::success(new PedidoResource($pedido));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function entregado(Pedido $pedido,Request $request){
        try {
            if($pedido->estado !== 'COMPLETADO'){
                return ApiResponse::error('El pedido se encuentra en estado '.$pedido->estado);
            }
            $monto = $this->detallePedidoRepository->montoTotal($pedido->id);
            $datos=[
                'monto_total'=> $monto,
                'fecha_entrega'=> Carbon::now(),
                'estado'=>'ENTREGADO'
            ];
            $pedido->update($datos);
            return ApiResponse::success(new PedidoResource($pedido));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function getMontoTotal($productos){
        return array_reduce($productos, function ($carry, $item){
            return $carry + (intval($item['cantidadSolicitada'])* doubleval($item['precioUnitario']));
        }, 0);
    }


    public function cantidades(Request $request){
        try {
            $cantidades = $this->pedidoRepository->getCantidadByEstado();
            $respuesta = [
                'total'=>$cantidades->sum('cantidad'),
                'estados'=>$cantidades
            ];
            return ApiResponse::success($respuesta);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function generarPdf(Pedido $pedido, Request $request){
        try {
            $productos = $this->detallePedidoRepository->getByPedido($pedido->id);
            $pedido->contacto = json_decode($pedido->contacto);
            $data = [
                'title'=>'PEDIDO',
                'pedido'=>new PedidoResource($pedido),
                'logo'=>$this->getLogoBase64(),
                'productos'=>$productos,
                'esOperador'=>$request->user()->rol->codigo !== 'ROL-003'
            ];
            $pdf = Pdf::loadView('pdf.pedido',$data);
            $pdf->setPaper('letter');
            return $pdf->download('pedido.pdf');
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function getLogoBase64(){
        $imagePath = public_path('image/logo_biotech_min.jpg');
        $base64Uri = '';
        if (file_exists($imagePath)) {
            $imageContent = file_get_contents($imagePath);
            $base64Image = base64_encode($imageContent);
            $mime = mime_content_type($imagePath);
            $base64Uri = 'data:' . $mime . ';base64,' . $base64Image;
        }
        return $base64Uri;
    }

    public function generarExcel(Pedido $pedido){
        try {
            $productos = $this->detallePedidoRepository->getByPedido($pedido->id);
            $montoTotal = array_reduce($productos, function ($carry, $item){
                return $carry + doubleval($item['monto']);
            }, 0);
            $templatePath = public_path('opa.xlsx');
            $pedido->contacto = json_decode($pedido->contacto);
            $data = [
                'B6'=> Carbon::parse($pedido->fecha)->format('d/m/Y'),
                'B7'=> $pedido->institucion,
                'B8'=> $pedido->ciudad,
                'B9'=> $pedido->nombre_usario_solicitante,
                'B10'=> $pedido->asunto,
                'B11'=>$pedido->comentario,
                'G6'=>$pedido->contacto->nombre,
                'G7'=>$pedido->contacto->cargo,
            ];
            $fila=14;
            //$columnas =['A','B','C','D','E','F','G','H'];
            foreach ($productos as $producto){
                $data['A'.$fila]=$producto->producto->codigo;
                $data['B'.$fila]=$producto->producto->descripcion.' - '.$producto->producto->presentacion->nombre;
                $data['C'.$fila]=$producto->cantidad;
                $data['D'.$fila]=$producto->producto->unidad;
                $data['E'.$fila]=$producto->precio;
                $data['F'.$fila]=$producto->monto;
                $data['G'.$fila]=$producto->producto->registro_sanitario_id?$producto->producto->registroSanitario->numero:'NO TIENE';
                $data['H'.$fila]=$producto->producto->temperatura?'DE '.$producto->producto->temperatura->min.' A '.$producto->producto->temperatura->max:'N/A';
                $fila++;
            }
            $data['E'.$fila]='TOTAL';
            $data['F'.$fila]=$montoTotal;

            $spreadsheet = IOFactory::load($templatePath);
            $hoja = $spreadsheet->getActiveSheet();


            foreach ($data as $cell=>$value){
                $hoja->setCellValue($cell,$value);
            }

            // Definir estilo de bordes
            $bordersStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ];
    
            // Aplicar estilo de bordes a las celdas de productos
            $startRow = 14;
            $endRow = $fila; // Hasta la fila donde está el total
            $hoja->getStyle("A{$startRow}:H{$endRow}")->applyFromArray($bordersStyle);

            $hoja->getStyle("B{$startRow}:B{$endRow}")
            ->getAlignment()
            ->setWrapText(true);
    

            $temporaryFilePath = storage_path('app/temp_report.xlsx');
            $writer = new Xlsx($spreadsheet);
            $writer->save($temporaryFilePath);
            return response()->download($temporaryFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function prueba(Request $request){
        try {
            $datos = [
                'institucion'=>'CAJA NACIONAL DE SALUD',
                'ciudad'=>'LA PAZ',
                'comentario'=>'RONAL Y TULIO',
                'estado'=>'SOLICITADO'
            ];
            $datos['contacto']= json_encode([
                'nombre'=>'JUAN LLUSCO',
                'cargo'=>'DIRECTOR',
                'celular'=>'75880746'
            ]);
            $cantidad = intval($request->query('cantidad'));
            $numeros = range(10, 500, 10);

            for ($i = 1; $i<=$cantidad; $i++){
                $datos['codigo']= $this->generarCodigo();
                $datos['fecha']= Carbon::now();
                $pedido = Pedido::create($datos);
                $pedido->save();
                $productos =  Producto::inRandomOrder()->take(10)->get();
                foreach ($productos as $producto) {
                    shuffle($numeros);
                    DetallePedido::create([
                        'pedido_id'=>$pedido->id,
                        'producto_id'=>$producto->id,
                        'cantidad'=>$numeros[0],
                        'tipo_producto'=>$producto->tipo,
                        'precio'=>0,
                        'monto'=>0,
                        'created_by'=>$request->user()->id
                    ]);
                }
            }
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function verHistorial (Pedido $pedido){
        try {
            $historial = $this->historialEstadoPedidoRepository->getByPedido($pedido->id);
            return ApiResponse::success($historial);
        } catch (\Exception $e) {
        return ApiResponse::exception($e);
        }
    }

    public function copiarPedido (Pedido $pedido){
        try {
            $cantidadProductosPedido = $this->detallePedidoRepository->cantidadProductosPedido($pedido->id);
            $idProductos = $this->detallePedidoRepository->getByPedidoIdProducto($pedido->id);
            $productosLista = $this->listaPrecioProductoRepository->getProductosVigentes($pedido->lista_precio_id,$idProductos);
            if($cantidadProductosPedido>count($productosLista)){
                return ApiResponse::error('No se puede realizar una copia del pedido, la lista de precios no tiene algunos productos');
            }
            $usuario = auth()->user();
            $data = [
                'contacto' => json_encode(json_decode($pedido->contacto,true)),
                'lista_precio_id' => $pedido->lista_precio_id,
                'usuario_solicitante_id' => $usuario->id,
                'nombre_usuario_solicitante' => trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido),
                'ciudad'=>$pedido->ciudad,
                'institucion'=>$pedido->institucion,
                'asunto'=>$pedido->asunto,
                'comentario'=>$pedido->comentario
            ];
            $nuevoPedido = Pedido::create($data);
            $productos = $this->detallePedidoRepository->getByPedido($pedido->id);
            $montoTotal = 0;
            foreach ($productos as $producto) {
                $monto = intval($producto->cantidad)* doubleval($productosLista[$producto->producto_id]);
                DetallePedido::create([
                    'pedido_id'=>$nuevoPedido->id,
                    'producto_id'=>$producto->producto_id,
                    'cantidad'=>$producto->cantidad,
                    'tipo_producto'=>$producto->tipo_producto,
                    'precio'=>$productosLista[$producto->producto_id],
                    'monto'=>$monto,
                    'created_by'=>$usuario->id
                ]);
                $montoTotal = $montoTotal + $monto;
            }
            HistorialEstadoPedido::create([
                'pedido_id'=>$nuevoPedido->id,
                'estado'=>'CREADO',
                'nombre_usuario'=>$data['nombre_usuario_solicitante'],
                'rol_usuario'=>$usuario->rol->nombre
            ]);
            $nuevoPedido->update(['monto_total'=>$montoTotal]);
            return ApiResponse::success(new PedidoResource($nuevoPedido));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function productosMasVendidos (){
        try {
            $productos = $this->detallePedidoRepository->getSumProductosVendidos();
            return ApiResponse::success(new DetallePedidoCollection($productos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}

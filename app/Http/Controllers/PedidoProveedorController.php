<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\DetallePedidoProveedor;
use App\Models\Pedido;
use App\Models\PedidoProveedor;
use App\Http\Resources\Biotech\DetallePedidoProveedorCollection;
use App\Http\Resources\Biotech\PedidoProveedorCollection;
use App\Http\Resources\Biotech\PedidoProveedorResource;
use App\Repository\DetallePedidoProveedorRepository;
use App\Repository\DetallePedidoRepository;
use App\Repository\PedidoProveedorRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PedidoProveedorController extends Controller
{
    private $detallePedidoRepository;
    private $pedidoProveedorRepository;
    private $detallePedidoProveedorRepository;

    public function __construct(
        DetallePedidoRepository $detallePedidoRepository,
        PedidoProveedorRepository $pedidoProveedorRepository, 
        DetallePedidoProveedorRepository $detallePedidoProveedorRepository)
    {
        $this->detallePedidoRepository = $detallePedidoRepository;
        $this->pedidoProveedorRepository = $pedidoProveedorRepository;
        $this->detallePedidoProveedorRepository = $detallePedidoProveedorRepository;
    }

    public function index(Request $request){
        try{
            $params = $request->query->all();
            $pedidos = $this->pedidoProveedorRepository->findAll($request->query->all());
            return ApiResponse::success( new PedidoProveedorCollection($pedidos));
        }catch (\Exception $e){
            return ApiResponse::exception($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $pedidos = Pedido::query()->where('estado','=','EN CURSO')->get();
            $idPedidos = $pedidos->pluck('id')->toArray();
            if(count($idPedidos)===0)
                return ApiResponse::error('No existen pedidos en estado EN CURSO');
            $productos = new Collection($this->detallePedidoRepository->getByPedidosPial($idPedidos)->toArray());
            $tipos = ['CONSUMIBLE','REACTIVO','RUO'];
            $usuario = $request->user();
            $fechaActual = Carbon::now();
            foreach ($tipos as $tipo){
                $productosFiltrados = $productos->filter(function ($producto) use($tipo) {
                    return $producto['tipo'] === $tipo;
                });
                $montoTotal = array_reduce($productosFiltrados->toArray(), function ($carry, $item){
                    return $carry + (intval($item['cantidad'])* doubleval($item['precio_exwork']));
                }, 0);
                $pial = PedidoProveedor::create([
                    'codigo'=>$this->generarCodigo(),
                    'usuario_solicitante_id'=> $usuario->id,
                    'nombre_usuario_solicitante'=>trim($usuario->nombres.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido),
                    'fecha'=>$fechaActual,
                    'tipo'=>$tipo,
                    'asunto'=>'PEDIDO DE '.$tipo,
                    'comentario'=>'PEDIDO DE '.$tipo.' SNIBE ',
                    'proveedor_id'=>'06deb956-745d-4d2e-bd72-10e40d59b61b',
                    'moneda'=>'DOLARES',
                    'monto_total'=>$montoTotal
                ]);
                foreach ($productosFiltrados as $producto){
                    DetallePedidoProveedor::create([
                        'pedido_proveedor_id'=>$pial->id,
                        'producto_id'=>$producto['producto_id'],
                        'cantidad'=>$producto['cantidad'],
                        'tipo_producto'=>$tipo,
                        'precio'=>$producto['precio_exwork'],
                        'monto'=>intval($producto['cantidad'])* doubleval($producto['precio_exwork']),
                        'created_by'=>$request->user()->id
                    ]);
                }
            }
            /** @var Pedido $pedido */
            foreach($pedidos as $pedido){
                $pedido->estado = 'COMPLETADO';
                $pedido->save();
            }
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function generarCodigo(){
        $meses = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
        $fechaActual = Carbon::now();
        $cantidadActual = $this->pedidoProveedorRepository->getCantidad($fechaActual->year,$fechaActual->month);
        $numero = str_pad($cantidadActual+1,3,'0',STR_PAD_LEFT);
        $mes=$meses[$fechaActual->format('n')-1];
        return $mes.$numero;
    }

    public function show(PedidoProveedor $pedidoProveedor){
        try {
            $productos = $this->detallePedidoProveedorRepository->getByPedido($pedidoProveedor->id);
            return ApiResponse::success([
                'pedido'=>new PedidoProveedorResource($pedidoProveedor),
                'productos'=>new DetallePedidoProveedorCollection($productos)
            ]);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function generarExcel(PedidoProveedor $pedidoProveedor){
        try{
            $productos = $this->detallePedidoProveedorRepository->getByPedido($pedidoProveedor->id);
            $templatePath = public_path('pial.xlsx');
            $data = [
                'C6'=>$pedidoProveedor->codigo,
                'C7'=>$pedidoProveedor->codigo,
                'C8'=>$pedidoProveedor->nombre_usuario_solicitante,
                'C9'=>$pedidoProveedor->asunto,
                'C10'=>$pedidoProveedor->comentario,
                'J6'=>'SNIBE',
                'J7'=>'CHINA',
                'J8'=>$pedidoProveedor->moneda,
                'J9'=>Carbon::parse($pedidoProveedor->fecha)->format('d/m/Y')
            ];
            $fila = 13;
            $numero = 1;
            //$columnas =['A','B','C','D','E','F','G','H'];
            foreach ($productos as $producto){
                $data['A'.$fila]=$numero;
                $data['B'.$fila]=$producto->producto->codigo;
                $data['C'.$fila]=$producto->producto->descripcion.' - '.$producto->producto->presentacion->nombre;
                $data['D'.$fila]=$producto->cantidad;
                $data['E'.$fila]=$producto->producto->unidad;
                $data['F'.$fila]='VARIOS';
                $data['G'.$fila]=$producto->precio;
                $data['H'.$fila]=$producto->monto;
                $data['I'.$fila]='VARIOS';
                $data['J'.$fila]=$producto->producto->registro_sanitario_id?$producto->producto->registroSanitario->numero:'NO TIENE';
                $data['K'.$fila]=$producto->producto->temperatura?'DE '.$producto->producto->temperatura->min.' A '.$producto->producto->temperatura->max:'N/A';
                $fila++;
                $numero++;
            }
            $data['G'.$fila]='TOTAL(USD)';
            $data['H'.$fila]=$pedidoProveedor->monto_total;

            $spreadsheet = IOFactory::load($templatePath);
            $hoja = $spreadsheet->getActiveSheet();
            foreach ($data as $cell=>$value){
                $hoja->setCellValue($cell,$value);
            }
            $temporaryFilePath = storage_path('app/temp_report.xlsx');
            $writer = new Xlsx($spreadsheet);
            $writer->save($temporaryFilePath);
            return response()->download($temporaryFilePath)->deleteFileAfterSend(true);

        }catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

}

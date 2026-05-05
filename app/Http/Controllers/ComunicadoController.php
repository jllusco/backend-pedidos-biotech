<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreComunicadoRequest;
use App\Http\Requests\UpdateComunicadoRequest;
use App\Http\Resources\ComunicadoCollection;
use App\Http\Resources\ComunicadoResource;
use App\Models\Comunicado;
use App\Repository\ComunicadoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComunicadoController extends Controller
{
    public function __construct(
        private ComunicadoRepository $comunicadoRepository
    ){}

    public function index(Request $request)
    {
        try {
            $params = $request->query->all();
            $comunicados = $this->comunicadoRepository->findAll($params);
            return ApiResponse::success( new ComunicadoCollection($comunicados));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function usuario(Request $request)
    {
        try {
            $comunicados = $this->comunicadoRepository->getActivosPorUsuario($request->user()->id);
            return ApiResponse::success($comunicados);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreComunicadoRequest $request)
    {
        try{
            return DB::transaction(function () use ($request) {
                $datos = $request->validated();
                if ($request->hasFile('imagen')) {
                    $datos['imagen'] = $request->file('imagen')->storeAs(
                        'comunicados',
                        uniqid() . '.' . $request->file('imagen')->extension(),
                        'public'
                    );
                }

                if ($request->hasFile('documento')) {
                    $datos['documento'] = $request->file('documento')->storeAs(
                        'comunicados',
                        uniqid() . '.' . $request->file('documento')->extension(),
                        'public'
                    );
                }

                $usuarios = $datos['usuarios'] ?? [];
                unset($datos['usuarios']);

                $comunicado = Comunicado::create($datos);

                if ($datos['audiencia'] === 'USUARIO' && !empty($usuarios)) {
                    $comunicado->usuarios()->sync($usuarios);
                }
                return ApiResponse::success(new  ComunicadoResource($comunicado));
            });
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comunicado $comunicado)
    {
        try {
            $comunicado->load('usuarios:id');
            return ApiResponse::success(new ComunicadoResource($comunicado));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComunicadoRequest $request, Comunicado $comunicado)
    {
        try {
            return DB::transaction(function () use ($request, $comunicado) {

                $datos = $request->validated();

                if ($request->hasFile('imagen')) {
                    $datos['imagen'] = $request->file('imagen')->storeAs(
                        'comunicados',
                        uniqid() . '.' . $request->file('imagen')->extension(),
                        'public'
                    );
                }

                // 📁 Documento (solo si viene archivo nuevo)
                if ($request->hasFile('documento')) {
                    $datos['documento'] = $request->file('documento')->storeAs(
                        'comunicados',
                        uniqid() . '.' . $request->file('documento')->extension(),
                        'public'
                    );
                }

                // 👥 usuarios
                $usuarios = $datos['usuarios'] ?? [];
                unset($datos['usuarios']);

                // actualizar datos base
                $comunicado->update($datos);

                // 🔥 lógica clave
                if ($datos['audiencia'] === 'USUARIO') {
                    $comunicado->usuarios()->sync($usuarios);
                } else {
                    // si cambia a GLOBAL → limpiar usuarios
                    $comunicado->usuarios()->sync([]);
                }

                return ApiResponse::success(
                    new ComunicadoResource(
                        $comunicado->load('usuarios:id')
                    )
                );
            });

        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateEstado(Comunicado $comunicado, Request $request){
        try {
            $estado = $request->request->get('estado');
            if(!$estado){
                throw new \Exception('El campo estado es requerido',400);
            }
            $comunicado->update(['estado'=>$estado]);
            return ApiResponse::success(new ComunicadoResource($comunicado));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comunicado $comunicado)
    {
        //
    }
}

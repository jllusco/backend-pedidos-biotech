<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\RolCollection;
use App\Http\Resources\RolResource;
use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Rol;
use App\Models\RolMenu;
use App\Models\RolPermiso;
use App\Repository\PermisoRepository;

class RolController extends Controller
{  
    public function index()
    {
        try {
            $roles = Rol::with('menus')->paginate();
            return ApiResponse::success( new RolCollection($roles));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
    
    public function store(StoreRolRequest $request)
    {
        try {
            $rol = Rol::create($request->all());
            $menus = $request->get('menus');
            RolMenu::where('rol_id', $rol->id)->delete();
            foreach ($menus as $menuId) {
                RolMenu::create([
                    'rol_id' => $rol->id,
                    'menu_id' => $menuId
                ]);
            }
            $permisos = $request->get('permisos');
            RolPermiso::where('rol_id', $rol->id)->delete();
            foreach ($permisos as $permisoId) {
                RolPermiso::create([
                    'rol_id' => $rol->id,
                    'permiso_id' => $permisoId
                ]);
            }
            return new RolResource($rol);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(Rol $rol)
    {
        try {
            $rol->load('menus');
            return ApiResponse::success(new RolResource($rol));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function update(UpdateRolRequest $request,Rol $rol)
    {
        try {
            $rol->update($request->all());
            $menus = $request->get('menus');
            RolMenu::where('rol_id', $rol->id)->delete();
            foreach ($menus as $menuId) {
                RolMenu::create([
                    'rol_id' => $rol->id,
                    'menu_id' => $menuId
                ]);
            }
            $permisos = $request->get('permisos');
            RolPermiso::where('rol_id', $rol->id)->delete();
            foreach ($permisos as $permisoId) {
                RolPermiso::create([
                    'rol_id' => $rol->id,
                    'permiso_id' => $permisoId
                ]);
            }
            return ApiResponse::success(new RolResource($rol));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }
    }

    public function permisos(Rol $rol, PermisoRepository $permisoRepository){
        try {
            $permisosRol = $permisoRepository->findAllSimple($rol->id);
            $permisos = $permisoRepository->findAllSimple();
            $permisos->each(function($item)use($permisosRol){
                $existe = $permisosRol->firstWhere('id', $item->id);
                $item->permitido = $existe ? true : false;
            });
            return ApiResponse::success($permisos);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}

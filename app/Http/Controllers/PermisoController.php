<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\PermisoCollection;
use App\Models\Permiso;
use App\Http\Requests\StorePermisoRequest;
use App\Http\Requests\UpdatePermisoRequest;
use App\Models\Rol;
use App\Repository\PermisoRepository;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    private  $permisoRepository;

    public function __construct(PermisoRepository $permisoRepository)
    {
        $this->permisoRepository = $permisoRepository;
    }
  
    public function index(Request $request)
    {
        try {
            $permisos = $this->permisoRepository->findAll($request->query->all());
            return ApiResponse::success( new PermisoCollection($permisos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

  
    public function store(StorePermisoRequest $request)
    {
        //
    }

 
    public function update(UpdatePermisoRequest $request, Permiso $permiso)
    {
        //
    }   
}

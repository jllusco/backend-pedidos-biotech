<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 11:44
 */

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Menu;
use App\Repository\PermisoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Repository\MenuRepository;
use DateTime;

class AuthController extends Controller
{
    private $menuRepository;
    private $permisoRepository;

    public function __construct(MenuRepository $menuRepository, PermisoRepository $permisoRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->permisoRepository = $permisoRepository;
    }

    public function login(Request $request)
    {
        try {
            $data = $request->request->all();
            $credentials = [
                "name"=>$data["usuario"],
                "password"=>$data["contrasena"]
            ];
            $response=[];
            if(Auth::attempt($credentials)){
                $user = Auth::user();
                if($user->estado === 'INACTIVO')
                    return ApiResponse::error('Su cuenta se encuentra inhabilitada, contactese con el administrador.');
                $user->rol;
                $response['usuario']=new UserResource($user);
                $response["menu"] = $this->menuRepository->obtenerMenusPorRol($user->rol_id);
                $response['permisos'] = $this->permisoRepository->findAllSimple($user->rol_id)->pluck('nombre')->toArray();
                $token = $user->createToken('token',$response['permisos']);
                $response['token']= $token->plainTextToken;
                $response['fechaActual'] = (new DateTime())->format('Y-m-d H:i:s');
                return ApiResponse::success($response);
            }else{
                return ApiResponse::error('Error en su usuario o su contraseña.');
            }
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
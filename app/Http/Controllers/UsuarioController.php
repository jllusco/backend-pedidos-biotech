<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 08:44
 */

namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepositoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private  $userRepository;

    public function __construct(UserRepositoy $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request){
        try {
            $usuarios = $this->userRepository->findAll($request->query->all());
            return ApiResponse::success( new UserCollection($usuarios));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreUsuarioRequest $request){
        try {
            $datos = $request->all();
            $datos["password"] = bcrypt($datos["password"]);
            $usuario = new UserResource(User::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(User $user)
    {
        try {
            return ApiResponse::success(new UserResource($user));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function update(User $user, UpdateUsuarioRequest $request){
        try {
            $datos = $request->all();
            unset($datos['password']);
            $user->update($datos);
            return ApiResponse::success(new UserResource($user));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateContrasena(Request $request){
        try {
            $data = $request->request->all();
            $user = $request->user();
            if(!Hash::check($data["contrasena"], $user->password)){
                return ApiResponse::error('Su contraseña actual no coincide con la registrada');
            }
            if($data["nuevaContrasena"]!==$data["confirmarContrasena"]){
                return ApiResponse::error('La confirmacion de la nueva contrasena no coincide');
            }
            $user->update([
                'password'=> bcrypt($data["nuevaContrasena"])
            ]);
            return ApiResponse::success(new UserResource($user));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateEstado(User $user, Request $request){
        try {
            $estado = $request->request->get('estado');
            if(!$estado){
                throw new \Exception('Estado es requerido',400);
            }
            $user->update(['estado'=>$estado]);
            return ApiResponse::success(new UserResource($user));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function restorePassword(User $user){
        try {
            $user->update([
                'password'=>bcrypt($user->numero_documento)
            ]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function getNotificaciones(){
        try {
            $notifications = auth()->user()->notifications;
            auth()->user()->unreadNotifications->markAsRead();
            return ApiResponse::success($notifications);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }


    public function getCantidadNotificaciones(){
        try {
            $cantidad = auth()->user()->unreadNotifications->count();
            return ApiResponse::success($cantidad);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }



}
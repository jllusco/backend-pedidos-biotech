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
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepositoy;
use Illuminate\Http\Request;

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

}
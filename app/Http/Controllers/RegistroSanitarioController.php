<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\RegistroSanitarioCollection;
use App\Http\Resources\RegistroSanitarioResource;
use App\Models\RegistroSanitario;
use App\Http\Requests\StoreRegistroSanitarioRequest;
use App\Http\Requests\UpdateRegistroSanitarioRequest;
use App\Repository\RegistroSanitarioRepository;
use Illuminate\Http\Request;

class RegistroSanitarioController extends Controller
{
    private $registroSanitarioRepository;

    public function __construct(RegistroSanitarioRepository $registroSanitarioRepository){
        $this->registroSanitarioRepository = $registroSanitarioRepository;
    }

    public function index(Request $request){
        try {
            $registros = $this->registroSanitarioRepository->findAll($request->query->all());
            return ApiResponse::success( new RegistroSanitarioCollection($registros));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreRegistroSanitarioRequest $request){
        try {
            $datos = $request->all();
            $registro = new RegistroSanitarioResource(RegistroSanitario::create($datos));
            return ApiResponse::success($registro);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}

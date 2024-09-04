<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Repository\CategoriaRepository;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function index(Request $request){
        try {
            $categorias = $this->categoriaRepository->findAll($request->query->all());
            return ApiResponse::success( new CategoriaCollection($categorias));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreCategoriaRequest $request){
        try {
            $datos = $request->all();
            $usuario = new CategoriaResource(Categoria::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}

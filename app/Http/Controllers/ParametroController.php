<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ParametroCollection;
use App\Http\Resources\ParametroResource;
use App\Models\Parametro;
use App\Http\Requests\StoreParametroRequest;
use App\Http\Requests\UpdateParametroRequest;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $parametros = Parametro::paginate();
            return ApiResponse::success( new ParametroCollection($parametros));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParametroRequest $request)
    {
        try {
            $parametro = new ParametroResource(Parametro::create($request->all()));
            //return new RolResource(Rol::create($request->all()));
            return ApiResponse::success($parametro);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Parametro $parametro)
    {
        try {
            return ApiResponse::success($parametro);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parametro $parametro)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParametroRequest $request, Parametro $parametro)
    {
        try {
            $parametro = $parametro->update($request->all());
            return ApiResponse::success($parametro);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parametro $parametro)
    {
        try {
            return $parametro->delete();
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}

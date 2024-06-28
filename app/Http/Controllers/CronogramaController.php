<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 28/6/2024
 * Time: 00:10
 */

namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\CronogramaCollection;
use App\Models\Cronograma;
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cronogramas = Cronograma::orderBy('mes')->paginate(12);
            return ApiResponse::success( new CronogramaCollection($cronogramas));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }

    }


}
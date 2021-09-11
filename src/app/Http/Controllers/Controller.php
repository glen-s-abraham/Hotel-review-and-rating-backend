<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json(["error" => $message, "code" => $code]);
    }

    public function showCollectionAsResponse(Collection $collection, $code = 200)
    {
        return $this->successResponse(["data" => $collection], $code);
    }

    public function showModelAsResponse(Model $model, $code = 200)
    {

        return $this->successResponse(["data" => $model], $code);
    }
}

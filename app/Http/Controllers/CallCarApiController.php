<?php

namespace App\Http\Controllers;

use App\Http\Services\CallApiFacadesService;

use Illuminate\Http\Request;

class CallCarApiController extends Controller
{
    public function getMakeController(CallApiFacadesService $requestCallApi){
        
        return  $requestCallApi->getMake();
    }
      public function getModelController(CallApiFacadesService $requestCallApi, Request $request){
        
        return  $requestCallApi->getModel($request);
    }
    public function getYearController(CallApiFacadesService $requestCallApi){
        
        return  $requestCallApi->getYear();
    }

}

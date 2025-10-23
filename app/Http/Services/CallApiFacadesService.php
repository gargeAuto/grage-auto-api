<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class CallApiFacadesService {
    public $BASE_URL="https://carapi.app/";
    
    public function requestShape($key, $allkey,$endPoint,$varEndPoint = null) 
    {
        $response = Http::get($this->BASE_URL.$endPoint."?make=${varEndPoint}" ?? '');
        
        if(!$key){
         return $name = collect($response->json());
        }
        $name = collect($response->json($key))->pluck($allkey);
        return  $name;
    }
    public function getMake(){
        $endPoint = "api/makes/v2";
        $key='data';
        $allkey='name';
        return $this->requestShape($key,$allkey,$endPoint);
    }
    public function getModel(Request $request){
        $endPoint = "api/models/v2";
        $key='data';
        $allkey='name';
        $varEndPoint = $request-> query("make");
        
        return $this->requestShape($key,$allkey,$endPoint,$varEndPoint);
    }
    public function getYear(){
        $endPoint = "api/years/v2";
        $key=null;
        $allkey=null;
        return $this->requestShape($key,$allkey,$endPoint);
    }
    
}
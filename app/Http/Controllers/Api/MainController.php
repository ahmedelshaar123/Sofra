<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\District;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function cities(){
        $cities = City::all();
        return apiResponse(1, "success", $cities);
    }

    public function filterCities(Request $request){
        $cities = City::where(function($query) use($request){
            if($request->has('keyword')){
                $query->where('name','like','%'.$request->keyword.'%');
            }
        })->paginate(10);
        return apiResponse(1, "success", $cities);
    }

    public function districts(Request $request){
        $districts = District::with('city')->where(function($query) use($request){
            if($request->has('city_id')){
                $query->where('city_id', $request->city_id);
            }

            if($request->has('keyword')){
                $query->where('name','like','%'.$request->keyword.'%');
            }

        })->paginate(10);
        return apiResponse(1, "success",$districts);
    }

    public function settings(){
        $settings = Setting::find(1);
        return apiResponse(1, "success", $settings);
    }
}

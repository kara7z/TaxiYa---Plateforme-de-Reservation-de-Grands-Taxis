<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

final class RouteController extends Controller
{
    public function getBasePrice(Request $request)
    {
        $startCityId = $request->query('start_city_id');
        $arrivalCityId = $request->query('arrival_city_id');

        $route = Route::where('start_city_id', $startCityId)
            ->where('arrival_city_id', $arrivalCityId)
            ->first();

        if ($route) {
            return response()->json([
                'base_price' => $route->base_price,
            ]);
        }

        return response()->json([
            'base_price' => null,
        ]);
    }
}

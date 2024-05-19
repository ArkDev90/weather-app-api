<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class weatherController extends Controller
{
 
 

    public function  getWeatherCityDetails(Request $request){


        try {
            // Validate the incoming request data
            $request->validate([
                'lat' => 'required|numeric|between:-90,90',
                'lon' => 'required|numeric|between:-180,180',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid latitude or longitude'], 500);
        }

        $latitude = $request->input('lat');
        $longitude = $request->input('lon');
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$apiKey}&units=metric";
        $response = Http::get($apiUrl);

        if ($response->successful()) {
           
            $data = $response->json();
            return response()->json($data);
        }

        return response()->json(['error' => 'Failed to fetch weather data from the API'], 500);
   
    
    }
}

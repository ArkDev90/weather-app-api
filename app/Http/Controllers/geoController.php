<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class geoController extends Controller
{
    //
    public function  getCityDetails(Request $request){
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
        $apiKey = env('GEOAPIFY_API_KEY');

        $apiUrl = "https://api.geoapify.com/v1/geocode/reverse?lat={$latitude}&lon={$longitude}&format=json&apiKey={$apiKey}";
    
        $response = Http::get($apiUrl);
        
        if ($response->successful()) {
           
            $data = $response->json();
            return response()->json($data);
        }

        return response()->json(['error' => 'Failed to fetch geo data from the API'], 500);
    }


    public function  getNearbyPlaces(Request $request){
        try {
            // Validate the incoming request data
            $request->validate([
                'cat' => 'required',
                'id' => 'required',
            ]);
        } catch (ValidationException $e) {
            
            return response()->json(['error' => 'Invalid parameter'], 500);
        }

        $category = $request->input('cat');
        $placeId = $request->input('id');

        $apiKey = env('GEOAPIFY_API_KEY');

        $apiUrl = "https://api.geoapify.com/v2/places?limit=10&categories={$category}&apiKey={$apiKey}&filter=place:{$placeId}";

        $response = Http::get($apiUrl);
        
        if ($response->successful()) {
           
            $data = $response->json();
            return response()->json($data);
        }

        return response()->json(['error' => 'Failed to fetch geo data from the API'], 500);
    }
}

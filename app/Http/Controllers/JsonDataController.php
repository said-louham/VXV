<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class JsonDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all platforms
        $platforms = Platform::all();

        $detailedPlatforms = [];
        $minimalPlatforms = [];

        foreach ($platforms as $platform) {
            $specFormat = $platform->data['spec_format'] ?? null;
            return ($specFormat);
            if ($specFormat && count($specFormat) > 0) {
                $detailedPlatforms[] = $platform->module;
            } else {
                $minimalPlatforms[] = $platform->module;
            }
        }

        return response()->json([
            'detailed' => $detailedPlatforms,
            'minimal' => $minimalPlatforms,
        ]);
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
    public function store(Request $request)
    {
        // Read the file contents from the given path
        $jsonFilePath = base_path('resources/data/data.json');


        $jsonData = file_get_contents($jsonFilePath);

        // Decode the JSON data into an array
        $dataArray = json_decode($jsonData, true);
        if ($dataArray === null) {
            return response()->json(['error' => 'Failed to decode JSON'], 500);
        }

        foreach ($dataArray as $item) {
            Platform::create([
                'module' => $item['module'],
                'data' => $item,
            ]);
        }

        return response()->json(['message' => 'Data stored successfully'], 201);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

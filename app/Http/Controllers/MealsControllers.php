<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealsControllers extends Controller
{
    public function store(Request $request)
    {
        $meal = Meal::create([
            'name' => $request->name,
            'image_url' => $request->image_url,
            'instruction_url' => $request->instruction_url,
            'html' => $request->html
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Meal has been created successfully',
            'meal' => $meal
        ], 201);
    }
}

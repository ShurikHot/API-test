<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionController extends Controller
{
    public function __invoke()
    {
        $positions = Position::query()->select('id', 'position')->get()->toArray();
        if ($positions) {
            return response()->json([
                'success' => true,
                'positions' => $positions
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Positions not found",
            ], 422);
        }
    }
}

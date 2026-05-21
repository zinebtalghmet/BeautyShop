<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\JsonResponse;

class SlideController extends Controller
{
    public function index(): JsonResponse
    {
        $slides = Slide::active()->get();

        return response()->json(['data' => $slides]);
    }
}

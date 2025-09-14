<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUrlRequest;
use App\Http\Resources\UrlResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $urls = UrlResource::collection($user->urls);

        $response = response()->json([
            'date' => $urls
        ]);

        return $response;
    }

    public function store(StoreUrlRequest $request): JsonResponse
    {
        $user = $request->user();

        $shortCode = Str::random(6);

        $url = $user->urls()->create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
        ]);

        $response = response()->json([
            'message' => 'URL shortened successfully',
            'data' => $url,
        ], 201);

        return $response;
    }
}

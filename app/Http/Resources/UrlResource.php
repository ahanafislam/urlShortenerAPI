<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'short_code' => $this->short_code,
            'short_url' => config('app.url') . "/{$this->short_code}",
            'visit_count' => $this->visit_count,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}

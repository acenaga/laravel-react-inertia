<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PuppyResource extends JsonResource
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
            'name' => $this->name,
            'trait' => $this->trait,
            'imageUrl' => $this->image_url,
            'likedBy' => $this->whenLoaded('likedBy', function () {
                return UserResource::collection($this->likedBy);
            }),
            'user' => UserResource::make($this->whenLoaded('user')),
            'can' => [
                'delete' => $request->user()?->can('delete', $this->resource) ?? false,
                'update' => $request->user()?->can('update', $this->resource) ?? false,
            ],
        ];
    }
}

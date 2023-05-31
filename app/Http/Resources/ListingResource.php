<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'location' => $this->location,
            'company' => $this->company_name,
            'company_email' => $this->company_email,
            'url' => $this->url,
            'tags' => $this->tags,
            'description' => $this->description,
            'status' => $this->status,
            'remote' => (bool)$this->remote,
            'created_at' => $this->created_at,
        ];
    }
}

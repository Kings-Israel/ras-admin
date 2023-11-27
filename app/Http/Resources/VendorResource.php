<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'about' => $this->about,
            'email' => $this->contact_email,
            'phone_number' => $this->contact_phone_number,
            'slug' => $this->slug,
            'primary_cover_image' => $this->primary_cover_image,
            'secondary_cover_image' => $this->secondary_cover_image,
            'country' => $this->country,
            'city' => $this->when($this->city_id, $this->city),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'product_name' => $this->product_name,
            'url' => $this->url,
            'brands' => $this->brands,
            'categories' => $this->categories,
            'status' => $this->status,
            'imported_t' => $this->imported_t,
            'image_url' => $this->image_url,
            'origins' => $this->origins,
            'last_modified_t' => $this->last_modified_t,
            'last_modified_datetime' => $this->last_modified_datetime,
            'imported_datetime' => $this->imported_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' =>   $this->name,
            'price' => $this->price,
            'image' =>  $this->images[0]['path'] ?? 'https://picsum.photos/id/160/600/600'
        ] ;
    }
}

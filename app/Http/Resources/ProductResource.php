<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $discountType = $this->discount->type;
        if($discountType=='percent') {
            $discountedPrice = $this->price - ($this->price * ($this->discount->discount/100)) ;
        } else {
            $discountedPrice = $this->price - $this->discount->discount ;
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "slug" => $this->slug,
            "price" => [
                            "full" => number_format($this->price,2,'.',','),
                            "discounted" => number_format($discountedPrice,2,'.',','),
                        ],
            "discount" => [
                            "type" => $discountType,
                            "amount" => $this->discount->discount
                        ],
            "images" => ProductImageResource::collection($this->images)
        ] ;
    }
}

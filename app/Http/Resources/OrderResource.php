<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => number_format($this->total_amount,2),
            'subtotal' => number_format($this->subtotal,2),
            'shipping' => number_format($this->shipping,2),
            'taxes' => number_format($this->taxes,2),
        ];
        
    }
}

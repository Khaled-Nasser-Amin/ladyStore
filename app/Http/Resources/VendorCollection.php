<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
                'id' => (int) $this->id,
                'name' => $this->store_name ,
                'image' => $this->image,
                'phone' => $this->phone."",
                'email' => $this->email,
                'whatsapp' => $this->whatsapp."",
                ];
    }
}

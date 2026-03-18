<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'role'=> $this->role,
            'name' => $this->name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'university' => $this->university,
            'image' =>  Storage::disk('public')->url($this->image),
        ];
    }
}

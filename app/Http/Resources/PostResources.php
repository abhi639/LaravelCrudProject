<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
               'postID'=> $this->postID,
            'title'=>$this->title,
         'imageName'=>$this->imageName,
         'created_at'=>$this->created_at,
         'updated_at'=>$this->updated_at,
           'details'=>$this->details,
           'user_id'=>$this->user_id
        ];
    }
}

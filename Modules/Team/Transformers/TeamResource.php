<?php

namespace Modules\Team\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name' =>  $this->name,
            'description' =>  $this->description,
            'leader' => $this->leader,
            'image' => $this->image,
            'students' => $this->students,
//            'invitations' => $this->invitations,
//            'joinRequests' => $this->joinRequests,
        ];
    }
}

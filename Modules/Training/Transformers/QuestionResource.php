<?php

namespace Modules\Training\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'content'=>$this->content,
            'answer'=>$this->answer,
            'choices'=>$this->choices,
        ];
    }
}

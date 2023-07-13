<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use JsonSerializable;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $author = $this->author;
        return [
            'id' => $this->id,
            'author' => $author->first_name,
            'email' => $this->email,
            'user_id' => $this->user_id,
            'school' => $this->school,
            'course' => $this->course,
            'grade' => $this->grade,
            'text' => $this->text,
            'status' => $this->status,
            'source' => $this->source,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
            'sort_order_on_home_page' => $this->sort_order_on_home_page,
            'show_on_home_page' => $this->show_on_home_page === 1
        ];
    }
}

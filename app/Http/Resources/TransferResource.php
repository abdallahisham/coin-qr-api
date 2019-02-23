<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = request()->user();
        $withUser = $this->sender->id == $user->id ? $this->receiver : $this->sender;
        $type = $this->sender->id == $user->id ? 's' : 'r';
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'user_name' => $withUser->name,
            'user_phone' => $withUser->phone,
            'type' => $type,
            'date' => $this->created_at->format('Y-m-d H:i')
        ];
    }
}

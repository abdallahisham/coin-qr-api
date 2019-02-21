<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        switch ($request->type) {
            case 'number':
                return [
                    'id' => $this->id,
                    'amount' => $this->amount,
                    'number' => $this->number,
                    'httpCode' => 200,
                ];
                break;
            case 'image':

                break;
        }
    }
}

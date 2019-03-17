<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;

class MessageResponse implements Arrayable
{
    protected $message;
    protected $code;

    public function __construct(string $message, int $code = 200)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function toArray()
    {
        return [
            'msg' => $this->message,
            'httpCode' => $this->code,
        ];
    }
}

<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class MessageResponse implements Responsable
{
    protected $message;
    protected $status;
    protected $payload;

    public function __construct(string $message, int $status = 200, array $payload = [])
    {
        $this->message = $message;
        $this->status = $status;
        $this->payload = $payload;
    }

    public function toResponse($request)
    {
        $response = array_merge([
            'httpCode' => $this->status,
            'msg' => $this->message,
        ], $this->payload);

        return new JsonResponse($response, $this->status);
    }
}

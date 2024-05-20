<?php

namespace Zmitroc\Rocketsms\Responses;

class StatusResponse
{
    public int $id;

    public string $status;

    public function __construct(array $response)
    {
        $this->id = $response['id'];
        $this->status = $response['status'];
    }
}

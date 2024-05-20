<?php

namespace Zmitroc\Rocketsms\Responses;

class AddSenderResponse
{
    public string $status;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
    }
}

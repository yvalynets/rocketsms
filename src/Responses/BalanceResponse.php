<?php

namespace Zmitroc\Rocketsms\Responses;

class BalanceResponse
{
    public int $credits;

    public float $balance;

    public function __construct(array $response)
    {
        $this->credits = $response['credits'];
        $this->balance = $response['balance'];
    }
}

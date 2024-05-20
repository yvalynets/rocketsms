<?php

namespace Zmitroc\Rocketsms\Structures;

class Sender
{
    public string $name;

    public bool $verified;

    public bool $checked;

    public bool $registered;

    public function __construct(array $senderData)
    {
        $this->name = $senderData['sender'];
        $this->verified = $senderData['verified'];
        $this->checked = $senderData['checked'];
        $this->registered = $senderData['registered'];
    }
}

<?php

namespace Zmitroc\Rocketsms\Structures;

class Template
{
    public string $id;

    public string $text;

    public function __construct(array $templateData)
    {
        $this->id = $templateData['tpl_id'];
        $this->text = $templateData['text'];
    }
}

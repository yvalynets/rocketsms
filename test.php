<?php

use Zmitroc\Rocketsms\ApiClient;

require_once 'vendor/autoload.php';

$a = new ApiClient('193187226', '5eDxk9Rc');
$b = $a->getStatus(237882862);
$c = $a->getBalance();
$d = $a->getSenders();
$e = $a->getTemplates();

$z = 1;

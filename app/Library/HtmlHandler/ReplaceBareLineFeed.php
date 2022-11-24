<?php

namespace App\Library\HtmlHandler;

use App\Library\StringHelper;
use League\Pipeline\StageInterface;

class ReplaceBareLineFeed implements StageInterface
{
    public function __invoke($html)
    {
        return StringHelper::replaceBareLineFeed($html);
    }
}

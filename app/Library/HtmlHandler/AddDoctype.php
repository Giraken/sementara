<?php

namespace App\Library\HtmlHandler;

use App\Library\StringHelper;
use League\Pipeline\StageInterface;

class AddDoctype implements StageInterface
{
    public function __invoke($html)
    {
        $closure = function () {
        };

        // Call StringHelper::updateHtml in order to have DOCTYPE available
        return StringHelper::updateHtml($html, $closure);
    }
}

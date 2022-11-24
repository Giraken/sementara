<?php

namespace App\Library\Contracts;

interface HasQuotaInterface
{
    public function getQuotaSettings(string $name): ?array;

    public function getUuid(): ?string;
}

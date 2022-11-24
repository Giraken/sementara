<?php

namespace App\Contracts;

interface Logable
{
	public function log(string $message): string;
}
